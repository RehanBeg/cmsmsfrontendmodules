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
use feu_utils;
use cge_utils;
use cge_param;

if( !isset($gCms) ) exit;
if( !$this->have_users_perm() ) return;

// this action handles the first portion of the add/edit user wizard.

try {
    $this->SetCurrentTab('users');
    if( isset($params['cancel']) ) {
        // we're cancelling.
        $this->SetMessage($this->Lang('msg_cancelled'));
        $this->RedirectToTab();
    }

    $user_id = cge_param::get_int($params,'user_id',-1);
    $user = $this->create_user_edit_assistant($user_id);
    try {
        $tmp = $this->retrieve_user_edit_assistant();
        $user = $tmp;
    }
    catch( \Exception $e ) {
        // nothing here
    }

    if( !empty($_POST) ) {
        try {
            // fill the data from the form
            if( !cge_param::exists($params, 'editanyway') ) {
                $user->new_username = cms_html_entity_decode(cge_param::get_string($params,'username'));
                $user->new_password = cms_html_entity_decode(cge_param::get_string($params,'password'));
                $user->repeat_password = cms_html_entity_decode(cge_param::get_string($params,'repeatpassword'));
            }
            $user->expires = cge_param::get_separated_date($params,'expires');
            $user->disabled = cge_param::get_bool($params,'disabled');
            if( !$user->nonstd ) {
                $user->force_chsettings = cge_param::get_bool($params,'force_chsettings');
                $user->force_newpw = cge_param::get_bool($params,'force_newpw');
                $user->must_validate = cge_param::get_bool($params,'must_validate');
            }
            $user->set_groups(cge_utils::get_param($params,'memberof'));

            // validate the data
            $user->validate();

            // save the data (temporarily)
            $this->store_user_edit_assistant($user);

            // redirect to the next step.
            $this->Redirect($id,'admin_edituser2',$returnid);
        }
        catch( \Exception $e ) {
            echo $this->ShowErrors($e->GetMessage());
        }
    }

    $tpl = $this->CreateSmartyTemplate('admin_edituser.tpl');
    $tpl->assign('formstart',$this->CGCreateFormStart($id,'admin_edituser',$returnid,[ 'user_id' => $user_id ]));
    $tpl->assign('formend',$this->CreateFormEnd());
    $tpl->assign('user',$user);
    $tpl->assign('prompt_username',$this->get_settings()->username_is_email ? $this->Lang('prompt_email') : $this->Lang('prompt_username'));
    $tpl->assign('unfldlen',80); // backwards compat
    $tpl->assign('max_unfldlen',$this->get_settings()->max_usernamelength);
    $tpl->assign('pwfldlen',80); // backwards compat
    $tpl->assign('max_pwfldlen',$this->get_settings()->max_passwordlength);
    $tpl->assign('require_onegroup',$this->get_settings()->require_onegroup);


    $default_group = $this->GetDefaultGroups();
    $default_group = $default_group[0];
    $tpl->assign('default_group',$default_group);
    $tpl->assign('groups',$this->GetGroupListFull());

    $tpl->display();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToTab();
}
