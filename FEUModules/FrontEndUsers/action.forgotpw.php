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
if( !isset($gCms) ) exit;

try {
    if( $this->get_settings()->disable_forgotpw ) throw new \CmsError403Exception('Permission denied');
    $username = $email = $error = $final_message = null;
    $username_is_email = $this->get_settings()->username_is_email;
    $nocaptcha = cge_param::get_bool($params,'nocaptcha',FALSE);
    $thetemplate = cge_param::get_string($params,'forgotpwtemplate','orig_forgotpassword.tpl');

    if( cge_param::exists($params,'feu_username') ) {
        try {
            if( !cge_utils::valid_form_csrf() ) throw new \LogicException( $this->Lang('error_security') );

            // make sure we have a username
            $username = cge_param::get_string($params,'feu_username');
            $username = cms_html_entity_decode($username);
            if( !$username ) throw new \RuntimeException($this->Lang('error_insufficientparams'));
            if( $username_is_email && !is_email($username) ) throw new \RuntimeException($this->Lang('error_invalidemailaddress'));

            // validate the captcha
            if( !$nocaptcha ) {
                $captcha = cms_utils::get_module('Captcha');
                if( is_object($captcha) && !$captcha->CheckCaptcha(cge_param::get_string($params,'feu_input_captcha')) ) {
                    throw new \RuntimeException($this->Lang('error_captchamismatch'));
                }
            }

            // see if we can find this user
            $uid = $this->GetUserID($username);
            if( !$uid ) throw new \RuntimeException($this->Lang('error_usernotfound'));
            $tmp = $this->GetUserInfo($uid);
            if( !$tmp || !$tmp[0] ) throw new \RuntimeException($this->Lang('error_couldnotfindemail'));
            $user_info = $tmp[1];
            unset($tmp);

            if( $user_info['disabled'] ) throw new \RuntimeException($this->Lang('error_accountdisabled'));
            if( $user_info['expired'] ) throw new \RuntimeException($this->Lang('error_accountexpired'));
            $email = $username;
            if( !$username_is_email ) {
                $email = $this->GetEmail($uid);
                if( !$email ) throw new \RuntimeException($this->Lang('error_couldnotfindemail'));
            }

            //
            // woot... at this point it all worked.
            // ready to get a temp code and send an email.
            //
            $code = feu_utils::generate_random_printable_string();
            $this->SetUserTempCode( $uid, $code );

            // send our funky email
            $eml = $this->get_email_storage()->load('forgotpassword.eml');
            $eml = $eml->add_data('code', $code);
            $eml = $eml->add_data('uid', $uid);
            $eml = $eml->add_data('src_page', $returnid);
            $eml = $eml->add_data('mod', $this);
            $eml = $eml->add_address($email);
            $sender = $this->create_new_mailprocessor( $eml );
            $sender->send();

            $this->add_history($uid,'forgotpw');

            // and we're done, do a redirect after post
            $final_message = $this->lang('info_forgotpwmessagesent',$email);
        }
        catch( \Exception $e ) {
            $error = $e->GetMessage();
        }
    }

    // create and display the template.
    $tpl = $this->CreateSmartyTemplate($thetemplate);
    $tpl->assign('error',$error);
    $tpl->assign('final_message', $final_message);
    $tpl->assign('username',$username);
    $captcha = $this->GetModuleInstance('Captcha');
    if( is_object($captcha) && !$nocaptcha ) {
        $tpl->assign('captcha_title',$this->Lang('captcha_title'));
        $tpl->assign('captcha',$captcha->getCaptcha());
        $test = method_exists($captcha, 'NeedsInputField') ? $captcha->NeedsInputField() : true;
        if( $test ) $tpl->assign('input_captcha', $this->CreateInputText($id,'feu_input_captcha','',10));
    }

    $tpl->assign('username_is_email',$username_is_email);
    $tpl->assign('unfldlen', 40); // backwards compat
    $tpl->assign('max_unfldlen', $this->get_settings()->max_usernamelength);
    $tpl->display();
}
catch( \Exception $e ) {
    cge_utils::log_exception($e);
    echo $this->DisplayErrorMessage($e->GetMessage());
}

#
# EOF
#
