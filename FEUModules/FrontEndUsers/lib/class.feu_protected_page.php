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
declare(strict_types=1);
namespace FrontEndUsers;
use Content;
use cms_utils;

abstract class base_protected_page extends Content
{
    protected $_data;
    const FEU_PROPNAME = '__feu_date__'; // oops: typo, can't change it now though.
    const TAB_FEU = 'cc_feu';

    protected function _getData()
    {
        if( !is_array($this->_data) ) {
            $tmp = $this->GetPropertyValue(self::FEU_PROPNAME);
            $this->_data = array();
            if( $tmp ) $this->_data = unserialize($tmp);
        }
    }

    protected function _setData()
    {
        if( is_array($this->_data) && count($this->_data) ) {
            $this->SetPropertyValue(self::FEU_PROPNAME,serialize($this->_data));
        }
        else {
            $this->SetPropertyValue(self::FEU_PROPNAME,'');
        }
    }

    protected function _isAuthorized()
    {
        // do we have access to it?
        $this->_getData();

        $feu = cms_utils::get_module(MOD_FRONTENDUSERS);
        if( $feu ) {
            $uid = $feu->LoggedInId();
            if( $uid ) {
                if( !isset($this->_data['groups']) || count($this->_data['groups']) == 0 ) {
                    // no member groups selected, but still logged in, we can display this.
                    return TRUE;
                }
                else {
                    // get member groups and do a cross reference.
                    $groups = $feu->GetMemberGroupsArray($uid);
                    if( !is_array($groups) || count($groups) == 0 ) return FALSE;
                    $membergroups = \cge_array::extract_field($groups,'groupid');
                    for( $i = 0; $i < count($this->_data['groups']); $i++ ) {
                        if( in_array($this->_data['groups'][$i],$membergroups) ) return TRUE;
                    }
                }
            }
        }
        return FALSE;
    }

    public function Type()
    {
        return 'feu_protected_page';
    }

    public function FriendlyName()
    {
        return cms_utils::get_module(MOD_FRONTENDUSERS)->Lang(get_class($this));
    }

    public function GetModifiedDate()
    {
        // on frontend requests this will force the template to be recompiled
        // and therefore evaluation to be done for each request.
        if( cmsms()->is_frontend_request() ) return time();
        return parent::GetModifiedDate();
    }

    public function SetProperties()
    {
        parent::SetProperties();
        $this->RemoveProperty('cachable','');
        if( version_compare(CMS_VERSION,'1.98') < 0 ) {
            $this->AddContentProperty('__feu_groups__',1);
        }
        else {
            $this->AddProperty('__feu_groups__',1,self::TAB_FEU);
        }
    }

    public function IsPermitted()
    {
        $r = $this->_isAuthorized();
        if( !$r ) {
            $feu = cms_utils::get_module(MOD_FRONTENDUSERS);
            if( \CmsApp::get_instance()->is_frontend_request() && $feu ) $feu->SetPostLoginUrl(\cge_url::current_url());
        }
        return $r;
    }

    // CMSMS 1.11.x and previous only
    public function TabNames()
    {
        $res = parent::TabNames();
        if( check_permission(get_userid(),'Manage All Content') ) {
            $res[] = cms_utils::get_module(MOD_FRONTENDUSERS)->Lang('frontend_access');
        }
        return $res;
    }

    public function ShowInMenu()
    {
        $res = parent::ShowInMenu();
        if( !$res || !\CmsApp::get_instance()->is_frontend_request() ) return $res;
        // frontend requests only
        return $this->_isAuthorized();
    }


    // CMSMS 2.0
    public function GetTabNames()
    {
        $out = parent::GetTabNames();
        if( !check_permission(get_userid(),'Manage All Content') ) {
            if( isset($out[self::TAB_FEU]) ) unset($out[self::TAB_FEU]);
        }
        else {
            if( isset($out[self::TAB_FEU]) ) {
                $feu = \cms_utils::get_module('FrontEndUsers');
                $out[self::TAB_FEU] = '--viewers--';
                if( $feu ) $out[self::TAB_FEU] = $feu->Lang('frontend_access');
            }
        }
        return $out;
    }

    // possible for 1.11.x, required for CMSMS 2.0
    protected function _display_single_element($one,$adding)
    {
        $feu = cms_utils::get_module(MOD_FRONTENDUSERS);
        if( !$feu ) return;

        switch( $one ) {
        case '__feu_groups__':
            $ret = array();
            // the permissions tab.
            $grouplist = array_flip($feu->GetGroupList());

            $this->_getData();
            if( !isset($this->_data['groups']) ) {
                if( ($groups = $feu->get_settings()->pagetype_groups) ) {
                    $tmp = explode(',', $groups);
                    if( is_array($tmp) && count($tmp) ) $this->_data['groups'] = $tmp;
                }
            }
            $size = min(count($grouplist),10);
            $tmp = array($feu->Lang('groups').':');
            $opt = '<select name="__feu_groups__[]" multiple="multiple" size="'.$size.'">';
            foreach( $grouplist as $gid => $gname ) {
                $selected = '';
                if( isset($this->_data['groups']) && in_array($gid,$this->_data['groups']) ) $selected='selected ';
                $opt .= '<option '.$selected.'value="'.$gid.'">'.$gname.'</option>';
            }
            $opt .= '</select><br/>'.$feu->Lang('info_contentpage_grouplist');
            $tmp[] = $opt;
            return $tmp;

        default:
            return parent::display_single_element($one,$adding);
        }
    }

} // end of class

if( version_compare(CMS_VERSION,'2.2.900') < 1) {
    class ProtectedPage extends base_protected_page {
        public function FillParams($params,$editing = false)
        {
            $this->_getData();
            if( isset($params['__feu_groups__']) ) {
                $this->_data['groups'] = $params['__feu_groups__'];
            }
            else if( isset($this->_data['groups']) ) {
                unset($this->_data['groups']);
            }
            parent::FillParams($params,$editing);
            $this->SetCachable(false);
        }

        protected function display_single_element($one, $adding)
        {
            return parent::_display_single_element($one,$adding);
        }

        public function Save()
        {
            $this->_setData();
            return parent::Save();
        }


    } // class
} else {
    class ProtectedPage extends base_protected_page {
        public function FillParams(array $params,bool $editing = null)
        {
            $this->_getData();
            if( isset($params['__feu_groups__']) ) {
                $this->_data['groups'] = $params['__feu_groups__'];
            }
            else if( isset($this->_data['groups']) ) {
                unset($this->_data['groups']);
            }
            parent::FillParams($params,$editing);
            $this->SetCachable(false);
        }

        protected function display_single_element(string $one, bool $adding)
        {
            return parent::_display_single_element($one,$adding);
        }

        public function PreSave()
        {
            $this->_setData();
            return parent::PreSave();
        }
    } // class
}
#
# EOF
#
