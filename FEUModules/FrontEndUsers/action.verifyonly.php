<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008-2016 by Robert Campbell
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
use feu_utils;
use CMSMS\HookManager;
if( !isset($gCms) ) exit;

// this is the result of the user being forced to verify the ownership of his email address
// just matches a tempcode with a uid. once done, a hook is emitted.
$title = $error = $final_msg = null;

try {
    $uid = cge_param::get_int($params,'uid');
    if( $uid < 1 ) throw new \RuntimeException($this->Lang('error_insufficientparams'));
    $uinfo = $this->get_user($uid);
    if( !$uinfo ) throw new \RuntimeException($this->Lang('error_usernotfound'));
    if( $uinfo['disabled'] ) throw new \RuntimeException($this->Lang('error_accountdisabled'));
    if( $uinfo['expired'] ) throw new \RuntimeException($this->Lang('error_accountexpired'));
    $code = cge_param::get_string($params,'code');
    if( !$code ) throw new \RuntimeException($this->Lang('error_insufficientparams'));
    if( $code == 'xxxx' ) $code = null;

    if( isset($params['feu_submit']) ) {
        try {
            // debug if( !cge_utils::valid_form_csrf() ) throw new \LogicException( $this->Lang('error_security') );

            $title = $this->Lang('account_verification');
            $error = false;

            if( !$this->VerifyUserTempCode($uid,$code) ) throw new \RuntimeException($this->Lang('error_invalidcode'));

            // success condition
            $this->RemoveUserTempCode($uid); // removes all codes.
            $this->ForceVerify($uid,FALSE);
            audit($uid,$this->GetName(),'Successfully verified his/her information');
            $this->add_history($uid,'verify complete');

            HookManager::do_hook( 'FrontEndUsers::AfterVerify', ['uid'=>$uid ] );

            $event_parms = [];
            $event_parms['id'] = $uid;
            $event_parms['name'] = $uinfo['username'];
            HookManager::do_hook('FrontEndUsers::OnUpdateUser',$event_parms);

            // if we have saved data AND we can login after verify
            // then log the user in.
            if( $this->get_settings()->login_after_verify ) {
                $data = feu_utils::retrieve_temp_logindata();
                if( $data ) {
                    $res = $this->Login( $data->username, $data->password, $data->onlygroups);
                    if( !$res[0] ) throw new FeuLoginFailedException($res[1]);
                    $uid = $res[0];
                }
            }

            // no pagetemplate or other error means no redirect
            // fall through to displaying a message
            $final_msg = $this->Lang('msg_verification_complete');
        }
        catch( \Exception $e ) {
            $error = $e->GetMessage();
        }
    } // submit

    // display the form
    $thetemplate = cge_param::get_string($params,'verifyonlytemplate','orig_verifyonly.tpl');
    $tpl = $this->CreateSmartyTemplate($thetemplate);
    $tpl->assign('uid',$uid);
    $tpl->assign('code',$code);
    $tpl->assign('error',$error);
    $tpl->assign('final_msg',$final_msg);
    $tpl->display();
}
catch( \Exception $e ) {
    $msg = $e->GetMessage();
    $error = true;
    $this->ShowFormattedMessage($msg,$error,$title);
}
