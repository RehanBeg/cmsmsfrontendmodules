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
if( !isset($gCms) ) exit;
if( !$this->have_users_perm() ) exit;

// this tab has merely one mofo list of uses and the ability to edit them,
// see details about them, and then delete them

//
// initialization
//
$this->SetCurrentTab('users');
$admintheme = cms_utils::get_theme_object();
$tpl = $this->CreateSmartyTemplate('admin_userlist.tpl');
$filter = $bare_filter = array('group'=>'','regex'=>'','loggedinonly'=>0,'limit'=>50,
                               'viewprops'=>[],'propsel'=>'','propval'=>'','sortby'=>'username asc',
                               'disabledstatus'=>'');
$tmp = cms_userprefs::get('feu_filter');
if( $tmp ) $filter = unserialize($tmp);

// bulk action stuff
if( isset( $params['dobulk']) ) {
    if( isset($params['selected']) && is_array($params['selected']) ) {
        $sel = base64_encode(serialize($params['selected']));
        $this->Redirect( $id, 'admin_bulkactions', $returnid, [ 'job'=>\cge_param::get_string($params,'bulk_action','delete'),'uids'=>$sel ] );
    }
}

// filtering stuff
if( isset( $params['filter_reset'] ) ) {
    cms_userprefs::remove('feu_filter');
    $this->session_clear('cur_page');
    $filter = $bare_filter;
}
else if( isset( $params['filter']) ) {
    $filter['group'] = get_parameter_value($params,'filter_group');
    $filter['regex'] = trim(get_parameter_value($params,'filter_regex'));
    $filter['loggedinonly'] = (int)get_parameter_value($params,'filter_loggedinonly');
    $filter['limit'] = (int)get_parameter_value($params,'filter_limit');
    $filter['sortby'] = trim(get_parameter_value($params,'filter_sortby'));
    $filter['viewprops'] = get_parameter_value($params,'filter_viewprops');
    $filter['propsel'] = trim(get_parameter_value($params,'filter_propertysel'));
    if( $filter['propsel'] == 'none' ) $filter['propsel'] = '';
    $filter['propval'] = trim(get_parameter_value($params,'filter_property'));
    $filter['disabledstatus'] = \cge_param::get_string( $params, 'filter_disabled');
    $this->session_clear('cur_page');
    cms_userprefs::set('feu_filter',serialize($filter));
}

$tpl->assign('filter',$filter);
$filterapplied = ($filter != $bare_filter);
$tpl->assign('filter_applied',$filterapplied);

// get a group list for the filter
// it should be ready to go right into the dropdown (cool eh)
$groups = null;
$groups1 = $this->GetGroupList();
if( is_array($groups1) && count($groups1) ) {
    $groups = array_merge( array($this->Lang('any') => -1), $groups1 );
    $tpl->assign('groups',array_flip($groups));
}

// a pulldown list for limits
$limits = array( '10' => 10,
                 '25' => 25,
                 '50' => 50,
                 '100' => 100,
                 '250' => 250,
                 '500' => 500 );
$tpl->assign('limits',$limits);

// a pulldown list for property definitions
$defns = $alldefns = [];
$defns1 = $this->GetPropertyDefns();
$defns['None'] = 'none';
if( is_array($defns1) ) {
    foreach( $defns1 as $def ) {
        if( $def['prompt'] == '' || $def['name'] == '' ) continue;
        $defns[$def['prompt']] = $def['name'];
        if( $def['type'] == 4 || $def['type'] == 7 )  $def['options'] = array_flip($this->GetSelectOptions($def['name']));
        $alldefns[$def['name']] = $def;
    }
}
$tpl->assign('defnlist',array_flip($defns));

// a pulldown list for sorting
$sorts = array( $this->Lang('sortby_username_asc') => 'username asc',
                $this->Lang('sortby_username_desc') => 'username desc',
                $this->Lang('sortby_create_asc') => 'createdate asc',
                $this->Lang('sortby_create_desc') => 'createdate desc',
                $this->Lang('sortby_expires_asc') => 'expires asc',
                $this->Lang('sortby_expires_desc') => 'expires desc' );
$tpl->assign('sortlist',array_flip($sorts));

// now setup the template fields
$tpl->assign( 'prompt_sort', $this->Lang('sort'));
$tpl->assign( 'startform', $this->CGCreateFormStart( $id, 'defaultadmin', $returnid, array('cg_activetab'=>'users')));
$tpl->assign( 'perm_removeusers', 1); // if we got here, we have permission
$tpl->assign( 'usersfound', $this->Lang('usersfound'));
$tpl->assign( 'alldefns',$alldefns);
$tpl->assign( 'viewprops',$filter['viewprops']);
$tpl->assign( 'endform', $this->CreateFormEnd ());

// now get our users
$users = null;
try {
    $curpage = $this->session_get('cur_page',1);
    $nmatches = 0;
    if( cge_param::exists($_POST,'page') ) {
        $curpage = cge_param::get_int($_POST,'page');
        $this->session_put('cur_page',$curpage);
    }
    $offset = ($curpage - 1) * $filter['limit'];
    $users = feu_utils::get_users_from_filter( $filter, $offset, $nmatches );
}
catch( LogicException $e ) {
    throw $e;
}
catch( Exception $e ) {
    $this->_DisplayErrorPage ($id, $params, $returnid, $e->GetMessage() );
}
if( empty($users) ) {
    // an error occurred
    $this->_DisplayErrorPage ($id, $params, $returnid, $db->ErrorMsg() );
}

// get the selected properties.
if( is_array($filter['viewprops']) && count($filter['viewprops']) ) {
    if( count($users) ) {
        $uids = array();
        foreach( $users as $row ) {
            $uids[] = $row->id;
        }

        $query = "SELECT A.id,";
        $flds = array();
        $conds = array();
        for( $i = 0; $i < count($filter['viewprops']); $i++ ) {
            $prop = $filter['viewprops'][$i];
            $nm = 'j'.$i;
            $flds[]  = "$nm.data as $prop";
            $conds[] = cms_db_prefix()."module_feusers_properties AS $nm ON A.id = $nm.userid AND ($nm.title = '$prop')";
        }
        $query .= implode(',',$flds).' FROM '.cms_db_prefix().'module_feusers_users A';
        $query .= ' LEFT JOIN '.implode(' LEFT JOIN ',$conds);
        $query .= ' WHERE A.id IN ('.implode(',',$uids).')';
        $dbr = $db->Execute('SET sql_big_selects = 1');
        $tmp = $db->GetArray($query);
        $extraprops = cge_array::to_hash($tmp,'id');
    }
}

if( $this->get_settings()->username_is_email ) {
    $tpl->assign('usernametext', $this->Lang('prompt_email'));
}
else {
    $tpl->assign('usernametext', $this->Lang('username'));
}
$tpl->assign('users',$users);
$bulk_actions = [];
$bulk_actions['disable'] = $this->Lang('bulk_disable');
$bulk_actions['enable'] = $this->Lang('bulk_enable');
$bulk_actions['forcechpw'] = $this->Lang('bulk_forcechpw');
$bulk_actions['forcechsettings'] = $this->Lang('bulk_forcechsettings');
$bulk_actions['forcevalidate'] = $this->Lang('bulk_forcevalidate');
$bulk_actions['setpassword'] = $this->Lang('bulk_setpassword');
$bulk_actions['setexpiry'] = $this->Lang('bulk_setexpiry');
$bulk_actions['delete'] = $this->Lang('bulk_delete');
if( count($bulk_actions) ) $tpl->assign('bulk_actions',$bulk_actions);

// todo: move these to creat_url in the template, but not a huge priority
if( $this->get_settings()->require_onegroup == 0 || count($groups1) > 0 ) {
    $tpl->assign('add_url', $this->create_url($id,'admin_edituser',$returnid));
}
if( !empty($groups) ) $tpl->assign('import_url',$this->create_url($id,'admin_import_users',$returnid));
if( !empty($users) ) $tpl->assign('export_url',$this->create_url($id,'admin_export_users',$returnid));

$tpl->display();
