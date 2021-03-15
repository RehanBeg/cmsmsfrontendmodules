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
// todo: rewrite me.
if( !isset($gCms) ) exit;
if( !$this->have_users_perm() ) exit;

$this->SetCurrentTab('userhistory');
$userid = \cge_param::get_int($params,'user_id');
$pagelimits = array();
$pagelimits['5'] = 5;
$pagelimits['10'] = 10;
$pagelimits['25'] = 25;
$pagelimits['50'] = 50;
$pagelimits['100'] = 100;
$pagelimits['250'] = 250;
$pagelimits['500'] = 500;

$datelist = array();
$datelist[$this->Lang('date_allrecords')] = -1;
$datelist[$this->Lang('date_onehourold')] = '1h';
$datelist[$this->Lang('date_sixhourold')] = '6h';
$datelist[$this->Lang('date_twelvehourold')] = '12h';
$datelist[$this->Lang('date_onedayold')] = '1d';
$datelist[$this->Lang('date_oneweekold')] = '1w';
$datelist[$this->Lang('date_twoweeksold')] = '2w';
$datelist[$this->Lang('date_onemonthold')] = '1m';
$datelist[$this->Lang('date_threemonthsold')] = '3m';
$datelist[$this->Lang('date_sixmonthsold')] = '6m';
$datelist[$this->Lang('date_oneyearold')] = '1y';

$sortorders = array();
$sortorders[$this->Lang('sortorder_date_desc')] = 'refdate DESC';
$sortorders[$this->Lang('sortorder_date_asc')] = 'refdate ASC';
$sortorders[$this->Lang('sortorder_action_desc')] = 'action DESC';
$sortorders[$this->Lang('sortorder_action_asc')] = 'action ASC';
$sortorders[$this->Lang('sortorder_ipaddress_desc')] = 'ipaddress DESC';
$sortorders[$this->Lang('sortorder_ipaddress_asc')] = 'ipaddress ASC';
if( $userid == '' ) {
    $sortorders[$this->Lang('sortorder_username_desc')] = 'username DESC';
    $sortorders[$this->Lang('sortorder_username_asc')] = 'username ASC';
}

$eventtypes = array();
$eventtypes['all'] = 'all';
$eventtypes['fail'] = 'fail';
$eventtypes['login'] = 'login';
$eventtypes['logout'] = 'logout';
$eventtypes['expire'] = 'expire';
$eventtypes['resetpw'] = 'resetpw';
$eventtypes['getusername'] = 'getusername';
$eventtypes['forgotpw'] = 'forgotpw';
$eventtypes['init_verify'] = 'init_verify';
$eventtypes['verify complete'] = 'verify complete';
$eventtypes['admin add user'] = 'admin add user';
$eventtypes['admin change settings'] = 'admin change settings';
if( isset( $params['submituserhistory'] ) ) {
    if( isset( $params['input_pagelimit'] ) ) $this->SetPreference('userhistory_pagelimit',$params['input_pagelimit']);
    if( isset( $params['input_sortorder'] ) ) $this->SetPreference('userhistory_sortorder',$params['input_sortorder']);
    if( isset( $params['input_eventtype'] ) ) $this->SetPreference('userhistory_eventtype',$params['input_eventtype']);
    if( isset( $params['input_filter_date'] ) ) $this->SetPreference('userhistory_date',$params['input_filter_date']);
    if( isset( $params['input_group_ip'] ) )  $this->SetPreference('userhistory_group_ip',$params['input_group_ip']);
    if( isset( $params['input_username_regex'] ) ) $this->SetPreference('userhistory_username_regex',$params['input_username_regex']);
    if( !$userid ) $this->RedirectToTab($id,'userhistory');
}
else if( isset( $params['reset'] ) ) {
    $this->SetPreference('userhistory_pagelimit',10);
    $this->SetPreference('userhistory_eventtype','all');
    $this->SetPreference('userhistory_date','-1'); // todo
    $this->SetPreference('userhistory_group_ip',0); // todo
    $this->SetPreference('userhistory_sortorder','refdate DESC');
    $this->SetPreference('userhistory_username_regex','');
    if( !$userid ) $this->RedirectToTab($id,'userhistory');
}

$input_pagelimit = (int)$this->GetPreference('userhistory_pagelimit',10);
$input_sortorder = $this->GetPreference('userhistory_sortorder','refdate DESC');
$input_eventtype = $this->GetPreference('userhistory_eventtype','all');
$input_filter_date = $this->GetPreference('userhistory_date','-1');
$input_group_ip = $this->GetPreference('userhistory_group_ip',0);
$input_username_regex = $this->GetPreference('userhistory_username_regex');

// Add the user info to smarty
if( $userid != '' ) {
    //$this->SetEncryptionKey($userid);
    $results = $this->GetUserInfo($params['user_id']);
    if( $results[0] === TRUE ) {
        $userinfo = $results[1];
        $smarty->assign('user',$userinfo);
        foreach( $userinfo->props as $name => $val ) {
            $smarty->assign('userprop_'.$name,$val);
        }
    }
}

// figure out what page we're on
$pagenumber = \cge_param::get_int($params,'pagenumber',1);
$startelement = ($pagenumber-1) * $input_pagelimit;

//
// Add the history to smarty
//
$where = array();
$parms = array();
$query1 = "SELECT A.*,B.username
             FROM ".cms_db_prefix()."module_feusers_history A,
                  ".cms_db_prefix()."module_feusers_users B
            WHERE A.userid = B.id";
$query2 = "SELECT COUNT(A.userid) AS count
             FROM ".cms_db_prefix()."module_feusers_history A,
                  ".cms_db_prefix()."module_feusers_users B
            WHERE A.userid = B.id";
if( $userid > 1 ) {
    $where[] = 'userid = ?';
    $parms[] = $userid;
}
else {
    // only use the username regex if the userid is empty
    if( $input_username_regex != '' ) {
        $where[] = 'username REGEXP ?';
        $parms[] = $input_username_regex;
    }
}
if( $input_eventtype != 'all' ) {
    $where[] = 'action = ?';
    $parms[] = $input_eventtype;
}
if( $input_filter_date != -1 ) {
    $date = '';
    switch( $input_filter_date ) {
    case '1h':
        $date = strtotime('1 hour ago');
        break;
    case '6h':
        $date = strtotime('6 hours ago');
        break;
    case '12h':
        $date = strtotime('12 hours ago');
        break;
    case '1d':
        $date = strtotime('1 day ago');
        break;
    case '1w':
        $date = strtotime('1 week ago');
        break;
    case '2w':
        $date = strtotime('2 weeks ago');
        break;
    case '1m':
        $date = strtotime('1 month ago');
        break;
    case '3m':
        $date = strtotime('3 months ago');
        break;
    case '6m':
        $date = strtotime('6 months ago');
        break;
    case '1y':
        $date = strtotime('1 year ago');
        break;
    }
    if( $date != '' ) {
        $where[] = 'refdate > ?';
        $parms[] = trim($db->DbTimeStamp($date),"'");
    }
}
if( count($where) > 0 ) {
    $query1 .= ' AND '.implode(' AND ',$where);
    $query2 .= ' AND '.implode(' AND ',$where);
}
if( $input_group_ip == 1 ) {
    $query1 .= ' GROUP BY ipaddress';
    $query2 .= ' GROUP BY ipaddress';
}
$query1 .= " ORDER BY ".$input_sortorder;
$query1 .= " LIMIT $startelement,$input_pagelimit";

// Now get the count, and number of pages
$tmprow = $db->GetRow( $query2, $parms );
$recordcount = $tmprow['count'];
$pagecount = (int)ceil($recordcount / $input_pagelimit);
$smarty->assign('recordcount',$recordcount);

// some pagination variables to smarty.
if( $pagenumber == 1 ) {
    $smarty->assign('prevpage','<');
    $smarty->assign('firstpage','<<');
}
else {
    $smarty->assign('prevpage',
                    $this->CreateLink($id,'defaultadmin', $returnid,'<',
                                      array('pagenumber'=>$pagenumber-1, 'user_id'=>$userid,'cg_activetab'=>'userhistory')));
    $smarty->assign('firstpage',
                    $this->CreateLink($id,'defaultadmin', $returnid,'<<',
                                      array('pagenumber'=>1, 'user_id'=>$userid,'cg_activetab'=>'userhistory')));
}
if( $pagenumber >= $pagecount ) {
    $smarty->assign('nextpage','>');
    $smarty->assign('lastpage','>>');
}
else {
    $smarty->assign('nextpage',
                    $this->CreateLink($id,'defaultadmin', $returnid,'>',
                                      array('pagenumber'=>$pagenumber+1, 'user_id'=>$userid,'cg_activetab'=>'userhistory')));

    $smarty->assign('lastpage',
                    $this->CreateLink($id,'defaultadmin', $returnid,'>>',
                                      array('pagenumber'=>$pagecount, 'user_id'=>$userid,'cg_activetab'=>'userhistory')));

}
$smarty->assign('pagenumber',$pagenumber);
$smarty->assign('pagecount',$pagecount);
$smarty->assign('oftext',$this->Lang('prompt_of'));
if( $userid == '' ) $smarty->assign('multiuser',1);

// The database query
$dbresult = $db->Execute( $query1, $parms );
$rowarray = array();
$rowclass = 'row1';
while( $dbresult && !$dbresult->EOF ) {
    $fields = $dbresult->fields;
    $onerow = new stdClass();
    foreach( $fields as $key => $value ) {
        $onerow->$key = $value;
    }

    // fix some fields up
    $onerow->refdate = $db->UnixTimeStamp($onerow->refdate);
    if( $onerow->ipaddress == '' ) $onerow->ipaddress = $this->Lang('unknown');
    $onerow->rowclass = $rowclass;

    $rowarray[] = $onerow;
    $rowclass = ($rowclass == 'row1') ? 'row2' : 'row1';
    $dbresult->MoveNext();
}

if( count($rowarray) == 0 ) $smarty->assign('message',$this->Lang('info_nohistorydetected'));
$smarty->assign('prompt_recordsfound',$this->Lang('prompt_recordsfound'));
$smarty->assign('title_legend_filter',$this->Lang('filter'));
$smarty->assign('title_legend_groupsort',$this->Lang('title_groupsort'));
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_userhistory'));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('submit',$this->CreateInputSubmit($id,'submituserhistory',$this->Lang('submit')));
$smarty->assign('reset',$this->CreateInputSubmit($id,'reset',$this->Lang('reset')));

$smarty->assign('prompt_pagelimit',$this->Lang('prompt_pagelimit'));
$smarty->assign('input_pagelimit', $this->CreateInputDropdown($id,'input_pagelimit',$pagelimits, -1, $input_pagelimit));

$smarty->assign('prompt_sortorder',$this->Lang('sortby'));
$smarty->assign('input_sortorder', $this->CreateInputDropdown($id,'input_sortorder',$sortorders, -1, $input_sortorder));

$smarty->assign('prompt_group_ip',$this->Lang('prompt_group_ip'));
$smarty->assign('input_group_ip',
                $this->CreateInputDropdown($id,'input_group_ip',
                                           array($this->Lang('yes')=>1, $this->Lang('no')=>0), -1, $input_group_ip));

$smarty->assign('prompt_username_regex',$this->Lang('userfilter'));
$smarty->assign('input_username_regex', $this->CreateInputText($id,'input_username_regex', $input_username_regex, 25));

$smarty->assign('prompt_filter_eventtype',$this->Lang('prompt_filter_eventtype'));
$smarty->assign('input_filter_eventtype', $this->CreateInputDropdown($id,'input_eventtype', $eventtypes, -1,$input_eventtype));
$smarty->assign('prompt_filter_date',$this->Lang('prompt_filter_date'));
$smarty->assign('input_filter_date', $this->CreateInputDropdown($id,'input_filter_date', $datelist,-1,$input_filter_date));

$smarty->assign('title_userhistory',$this->Lang('title_userhistory'));
$smarty->assign('for',$this->Lang('for'));
$smarty->assign('prompt_username',$this->Lang('prompt_username'));
$smarty->assign('prompt_for',$this->Lang('prompt_for'));
$smarty->assign('items',$rowarray);
$smarty->assign('itemcount',count($rowarray));
$smarty->assign('prompt_refdate',$this->Lang('prompt_date'));
$smarty->assign('prompt_action',$this->Lang('prompt_eventtype'));
$smarty->assign('prompt_ipaddress',$this->Lang('prompt_ipaddress'));

echo $this->ProcessTemplate('userhistory.tpl');
// EOF
