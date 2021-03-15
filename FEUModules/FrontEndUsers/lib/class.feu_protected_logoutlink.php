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
declare(strict_types=1);

// 99% of this class (all of it?) could be in a trait, as it is initially just copied from the FEU protected page class.
class feu_protected_logoutlink extends ContentBase
{
    public function IsCopyable() { return TRUE; }
    public function IsViewable() { return FALSE; }
	public function HasSearchableContent() { return FALSE; }

    function SetProperties()
    {
		parent::SetProperties();
		$this->RemoveProperty('secure','');
		$this->RemoveProperty('cachable','');
		$this->RemoveProperty('showinmenu','1');
		$this->RemoveProperty('page_url','');
    }

    private function _isAuthorized()
    {
        // do we have access to it?
        $feu = cms_utils::get_module(MOD_FRONTENDUSERS);
        if( $feu ) {
            $uid = $feu->LoggedInId();
            if( $uid ) return TRUE;
        }
        return FALSE;
    }

    public function FriendlyName()
    {
        return cms_utils::get_module(MOD_FRONTENDUSERS)->Lang(get_class());
    }

    public function GetModifiedDate()
    {
        // on frontend requests this will force the template to be recompiled
        // and therefore evaluation to be done for each request.
        if( cmsms()->is_frontend_request() ) return time();
        return parent::GetModifiedDate();
    }

    public function IsPermitted()
    {
        return $this->_isAuthorized();
    }

    public function ShowInMenu()
    {
        $res = parent::ShowInMenu();
        if( !$res ) return $res;
        $res = $this->_isAuthorized();
        return $res;
    }

    function GetURL($rewrite = true)
    {
        $feu = cms_utils::get_module(MOD_FRONTENDUSERS);
        $page_id = ContentOperations::get_instance()->GetDefaultContent();
        return $feu->create_url('cntnt01','logout',$page_id);
    }

} // end of class
