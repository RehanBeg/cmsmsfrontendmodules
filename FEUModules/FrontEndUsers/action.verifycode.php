<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008-2014 by Robert Campbell
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
use cge_utils;
use cge_param;
use CMSMS\HookManager;
if( !isset($gCms) ) exit;

// this handles the response to the forgotten password reuest
// the user must have the code and must reset the password.
$username = $fatal = $error = $message = $final_msg = null;
$template = cge_param::get_string($params,'verifycodetemplate', 'orig_verifycode.tpl');
$uid = cge_param::get_int($params,'uid');
$code = cge_param::get_string($params,'code');
$username_is_email = $this->get_settings()->username_is_email;
$password1 = cge_param::get_string($params,'password1');
$password2 = cge_param::get_string($params,'password2');
$tpl = $this->CreateSmartyTemplate($template);

try {
    if( $uid < 1 ) throw new \LogicException($this->Lang('error_insufficientparams').' 1');
    $uinfo = $this->get_user($uid);
    if( !$uinfo ) throw new \LogicException($this->Lang('error_usernotfound'));
    if( $uinfo['disabled'] ) throw new \LogicException($this->Lang('error_accountdisabled'));
    if( time() > strtotime($uinfo['expires']) ) throw new \LogicException($this->Lang('error_accountexpired'));
    $username = $uinfo['username'];

    if( cge_param::get_string($params,'after') ) {
        // in redirect after POST
        $final_msg = $this->Lang('info_password_reset');
    }
    if( !empty($_POST) && cge_param::exists($params,'code') ) {
        if( !cge_utils::valid_form_csrf() ) throw new \LogicException( $this->Lang('error_security') );

        $code = cge_param::get_string($params,'code');
        $password1 = cms_html_entity_decode(cge_param::get_string($params,'password1'));
        $password2 = cms_html_entity_decode(cge_param::get_string($params,'password2'));
        if( !$this->IsValidPassword($password1) ) throw new \RuntimeException($this->Lang('error_invalidpassword'));
        if( $password1 != $password2 ) throw new \RuntimeException($this->Lang('error_passwordmismatch'));
        if( !$this->VerifyUserTempCode($uid, $code) ) throw new \RuntimeException($this->Lang('error_invalidcode'));
        $this->SetUserPassword($uid,$password1);
        $this->RemoveUserTempCode($uid);
        $username = $this->GetUsername($uid);

        // and send an event
        $event_params = array();
        $event_params['name'] = $username;
        $event_params['id'] = $uid;
        HookManager::do_hook('FrontEndUsers::OnUpdateUser',$event_params);

        // and audit it
        audit($uid,$this->GetName(),'Successfully changed password via forgotpw');
        $this->add_history($uid,'changed password');

        // redirect after POST
        $this->redirect('cntnt01','verifycode',$returnid,['after'=>1,'uid'=>$uid]);
    }
}
catch( \RuntimeException $e ) {
    $error = $e->GetMessage();
}
catch( \LogicException $e ) {
    $error = $e->GetMessage();
}

// create the template
$tpl->assign('unfldlen', 40); // backwards compat
$tpl->assign('max_unfldlen', $this->get_settings()->max_usernamelength);
$tpl->assign('pwfldlen', 80);
$tpl->assign('max_pwfldlen', $this->get_settings()->max_passwordlength);
$tpl->assign('username_is_email', $username_is_email);
$tpl->assign('username', $username);
$tpl->assign('password1', $password1);
$tpl->assign('password2', $password2);
$tpl->assign('code', $code);
$tpl->assign('uid', $uid);
$tpl->assign('error', $error);
$tpl->assign('user_info', $uinfo);
$tpl->assign('final_msg', $final_msg);
$tpl->display();
