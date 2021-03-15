<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008-2015 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management of frontend
#  users, and their login process within a CMS Made Simple powered
#  website.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE
namespace FrontEndUsers;
use cge_param;
use cge_utils;
use cms_utils;
use feu_utils;
use CMSMS\HookManager;
if( !isset($gCms) ) return;

try {
    $uid = null;
    $settings = $this->get_settings();
    if( $settings->disable_login ) return;
    $error = $username = $password = $rememberme = $final_msg = $reverify = $further_action_required = $requested_url = $user_info = null;
    $onlygroups = cge_param::get_string($params,'onlygroups');
    $nocaptcha = cge_param::get_bool($params,'nocaptcha');
    $inline = cge_param::get_bool($params,'inline');

    if( cge_param::exists($params,'after') ) {
        // here we determine what should happen after login
        // and then ensure it is provided to smarty for final determiniation
        $uid = $this->LoggedInId();
        if( $uid < 1 ) throw new \LogicException('Could not determine logged in uid');
        $requested_url = $this->GetPostLoginURL();
        $user_info = $this->get_user($uid);
        if( $user_info->force_chsettings ) {
            $further_action_required = 'changesettings';
        } else if( !$user_info->nonstd && $user_info->force_newpw ) {
            $further_action_required = 'user_forcenew';
        }
        $final_msg = $this->Lang('msg_loginsuccess');
        header("Location: http://".$_SERVER['HTTP_HOST']);
    }
    else if( cge_param::exists($params,'feu__data') ) {
        $username = $ip = null;
        try {
            // check the CSRF stuff.
            if( !cge_utils::valid_form_csrf() ) throw new \RuntimeException( $this->Lang('error_security') );

            // check the honeypot
            if( isset($params['feu__data']) ) {
                $honeypot = cge_param::get_string($params, 'feu__data');
                if( $honeypot ) throw new \RuntimeException($this->Lang('error_security'));
            }

            // this is the guts of the login process.
            $username = cms_html_entity_decode(cge_param::get_string($params, 'feu_input_username'));
            $password = cms_html_entity_decode(cge_param::get_string($params, 'feu_input_password'));
            $rememberme = cge_param::get_bool($params, 'feu_rememberme') && !$settings->disable_rememberme;

            // check username & password
            if( !$username ) throw new \RuntimeException($this->Lang('error_missingusername'));
            if( !$password ) throw new \RuntimeException($this->Lang('error_missingpassword'));

            // do BeforeLogin... these references are pretty hacky
            $ip = cge_utils::get_real_ip();
            $ok = true;
            $msg = null;
            $parms = ['username'=>$username, 'groups'=>$onlygroups, 'ip'=>$ip, 'allow'=>&$ok, 'message'=>&$msg];
            HookManager::do_hook('FrontEndUsers::BeforeLoginAuth', $parms);
            if( !$msg ) $msg = $this->Lang('error_otherlogin_propblem');
            if( !cms_to_bool($ok) ) throw new FeuLoginFailedException($msg);

            // check the captcha
            if( !$nocaptcha ) {
                $captcha = cms_utils::get_module('Captcha');
                if( is_object($captcha) && !$captcha->CheckCaptcha(cge_param::get_string($params,'feu_input_captcha')) ) {
                    throw new FeuLoginFailedException($this->Lang('error_captchamismatch'));
                }
            }

            // check password, but do not login
            $uid = $this->CheckPassword($username, $password, $onlygroups );
            if( $uid < 1 ) throw new FeuLoginFailedException($this->Lang('error_loginfailed'));

            // get uid and userinfo
            $user_info = $this->get_user($uid);
            if( !$user_info ) throw new \RuntimeException($this->Lang('error_usernotfound')); // should never ever happen.
            if( $user_info->nonstd ) throw new FeuLoginFailedException('Non standard users cannot login using this form');
            if( $user_info->is_disabled() ) throw new FeuLoginFailedException($this->Lang('error_accountdisabled'));
            if( $user_info->is_expired() ) throw new FeuLoginFailedException($this->Lang('error_accountexpired'));
            if( $user_info->must_validate && $user_info->verify_code && !$settings->disable_reverify ) {
                // we are awaiting the user to verify themselves., but they managed to login??
                $reverify = true;
                throw new FeuLoginFailedException($this->Lang('error_accountneedsverification'));
            }

            // cannot remember the user if he is forced to change passwords.
            $rememberme = $rememberme && !$user_info->force_newpw && !$user_info->nonstd;

            // in cases of 2FA we may need to redirect out of here
            // login passed... now do the afterloginauth event
            // to see if any other module is preventing login.
            // references are pretty hacky.
            $ok = true;
            $msg = null;
            $parms = [ 'id'=>$uid, 'username'=>$username, 'groups'=>$onlygroups, 'ip'=>$ip, 'rememberme'=>&$rememberme, 'allow'=>&$ok, 'message'=>&$msg ];
            HookManager::do_hook('FrontEndUsers::AfterLoginAuth', $parms);
            if( !$msg ) $msg = $this->Lang('error_otherlogin_propblem');
            if( !cms_to_bool($ok) ) throw new FeuLoginFailedException($msg);

            // actually log the user in.  at this point this should never fail, as we have already checked the passowrd etc.
            $this->SetUserLoggedin( $uid, $rememberme );

            //
            // we're logged in
            //

            // redirect after post
            $this->redirect($id,'login',$returnid,['after'=>$uid],$inline);
        }
        catch( FeuLoginFailedException $e ) {
            $error = $e->GetMessage();
            audit('',$this->GetName(),'Login failed for user '.$username);
            if( $uid ) $this->add_history($uid,'login failed');
            HookManager::do_hook('FrontEndUsers::OnLoginFailed', ['uid'=>$uid, 'username'=>$username, 'msg'=>$error]);
        }
        catch( \Exception $e ) {
            $error = $e->GetMessage();
        }
    }

    // build the form
    $content = cms_utils::get_current_content();
    if( get_class($content) == 'ErrorPage' && !$this->hasPostLoginUrl() ) {
        // we're being called from an error page... so when we're done we want to redirect back to the
        // requested page, if enabled.
        $this->SetPostLoginURL($_SERVER['REQUEST_URI']);
    }

    $thetemplate = cge_param::get_string($params,'logintemplate','orig_loginform.tpl');
    $tpl = $this->CreateSmartyTemplate($thetemplate);

    $captcha = $this->GetModuleInstance('Captcha');
    if( is_object($captcha) && !$nocaptcha ) {
        $test = method_exists($captcha, 'NeedsInputField') ? $captcha->NeedsInputField() : true;
        $tpl->assign('captcha_title', $this->Lang('captcha_title'));
        $tpl->assign('captcha', $captcha->getCaptcha());
        $tpl->assign('need_captcha_input',$test);
    }

    $tpl->assign('user_info', $user_info);
    $tpl->assign('requested_url', $requested_url);
    $tpl->assign('final_msg', $final_msg);
    $tpl->assign('error', $error);
    $tpl->assign('username_is_email', $settings->username_is_email);
    $tpl->assign('fldname_username', $id.'feu_input_username');
    $tpl->assign('username_maxlength', $settings->max_usernamelength);
    $tpl->assign('password_maxlength', $settings->max_passwordlength);
    $tpl->assign('username_size', 40); // backwards compat
    $tpl->assign('password_size', 80);
    $tpl->assign('username', $username);
    $tpl->assign('password', $password);
    $tpl->assign('rememberme', $rememberme);
    $tpl->assign('reverify', $reverify); // option to send another verification code email.
    $tpl->assign('fldname_password', $id.'feu_input_password');
    $tpl->assign('inline', $inline);
    $tpl->assign('onlygroups',$onlygroups);
    if( !$settings->disable_rememberme ) {
        $tpl->assign('fldname_rememberme', $id.'feu_rememberme');
    }
    $tpl->assign('allow_forgotpw', !$settings->disable_forgotpw);
    $tpl->assign('allow_lostusername', !$settings->disable_lostusername);
    $tpl->display();
}
catch( \Exception $e ) {
    // fatal exceptions we can do nothing without.
    cge_utils::log_exception($e);
    echo $this->DisplayErrorMessage($e->GetMessage());
}
// EOF
