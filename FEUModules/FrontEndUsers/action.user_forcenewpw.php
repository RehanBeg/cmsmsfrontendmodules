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
if( !defined('CMS_VERSION') ) exit;

$error = $final_msg = null;
$template = cge_param::get_string($params,'forcenewpwtemplate','orig_force_newpw_form.tpl');
$tpl = $this->CreateSmartyTemplate($template);

try {
    $uid = (int) cge_utils::get_param($params,'uid');
    if( $uid < 1 ) throw new \RuntimeException($this->Lang('error_invalidparams'));
    $uid2 = $this->LoggedInId();
    if( $uid != $uid2 ) throw new \RuntimeException($this->Lang('error_invalidparams'));
    $tpl->assign('uid',$uid);

    if( ($this->session_get('feu_afterpost') == 1) ) {
        $this->session_clear('feu_afterpost');
        $final_msg = $this->Lang('msg_thankyou');
    }
    else if( !empty($_POST) ) {
        try {
            if( !cge_utils::valid_form_csrf() ) throw new FeuChangeSettingsError( $this->Lang('error_security') );
            $pw1 = cms_html_entity_decode(cge_utils::get_param($params,'feu_password'));
            $pw2 = cms_html_entity_decode(cge_utils::get_param($params,'feu_repeatpassword'));

            // see if it is a valid password.
            if( $pw1 != $pw2 ) throw new \RuntimeException($this->Lang('error_passwordmismatch'));
            if( !$this->IsValidPassword($pw1 ) ) throw new \RuntimeException($this->Lang('error_invalidpassword'));

            // set the password
            $this->SetUserPassword($uid,$pw1);
            $this->ForcePasswordChange($uid,FALSE);

            // and redirect out of here.
            if( ($url = $this->GetPostLoginURL()) ) redirect($url);

            // redirect after post
            $this->session_put('feu_afterpost',1);
            $this->Redirect('cntnt01','user_forcenewpw',$returnid, ['uid'=>$uid ]);
        }
        catch( \Exception $e ) {
            $error = $e->GetMessage();
        }
    }
}
catch( \Exception $e ) {
    // on error, we just display a message.
    cge_utils::log_exception($e);
    $error = $e->GetMessage();
}

$tpl->assign('final_msg',$final_msg);
$tpl->assign('error',$error);
$tpl->display();