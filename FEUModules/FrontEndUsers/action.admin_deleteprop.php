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

if( !isset($gCms) ) exit;
if( !$this->have_props_perm() ) exit;
$this->SetCurrentTab('properties');

try {
    $propname = cge_param::get_string($params,'propname');
    if( !$propname ) return;

    // get the details about this property
    // make sure it's not a required/hidden property in any group (OFF OR OPTIONAL only)
    // IF IT IS, we cannot delete it... so we just throw an exception and get outa here
    $can_delete = TRUE;
    $propgroups = $this->GetPropertyGroupRelations($propname);
    if( !empty($propgroups) ) {
        foreach( $propgroups as $rec ) {
            if( $rec['required'] > 1 ) {
                $can_delete = FALSE;
                break;
            }
        }
    }
    if( !$can_delete ) throw new \RuntimeException($this->Lang('error_delete_propdefn'));

    // handle submit & cancel
    if( isset($params['cancel']) ) {
        $this->SetMessage($this->Lang('msg_cancelled'));
        $this->RedirectToTab($id);
    }
    if( isset($params['submit']) ) {
        $feu_confirm = cge_param::get_bool($params,'feu_confirm');
        if( !$feu_confirm ) throw new \RuntimeException($this->Lang('error_action_notconfirmed'));

        // now ready to delete the property
        $result = $this->DeletePropertyDefn( $propname );
        if( !$result ) throw new \RuntimeException($this->Lang('error_deleteprop'));

        audit('',$this->GetName(),'Removed propertyy '.$propname);
        $this->RedirectToTab($id,'properties');
    }

    // give verything to smarty
    $types = $this->GetFieldTypes();
    unset($types['data']);
    $fieldtypes = array_flip($this->langifyKeys($types));

    $defn = $this->GetPropertyDefn($propname);
    $tpl = $this->CreateSmartyTemplate('admin_deleteprop.tpl');
    $tpl->assign('fieldtypes',$fieldtypes);
    $tpl->assign('propname',$propname);
    $tpl->assign('defn',$defn);
    $tpl->assign('formstart',$this->CGCreateFormSTart($id,'admin_deleteprop',$returnid,array('propname'=>$propname)));
    $tpl->assign('formend',$this->CreateFormEnd());
    $tpl->display();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToTab($id);
}



?>