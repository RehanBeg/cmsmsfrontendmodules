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

// Get the start date
$date = '-1';
switch( $params['input_clearuserhistory'] ) {
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

$db = \cge_utils::get_db();
try {
    $db->BeginTrans();
    $query = "DELETE FROM ".cms_db_prefix()."module_feusers_history";
    $parms = array();
    if( $date != -1 )  {
        $query .= " WHERE refdate < ?";
        $parms[] = trim($db->DBTimeStamp($date),"'");
    }

    $db->Execute( $query, $parms );
    $db->CommitTrans();
    $this->RedirectToTab($id,'admin');
}
catch( \Exception $e ) {
    $db->RollbackTrans();
    audit('',$this->GetName(),'Problem clearing user history');
    debug_to_log(__METHOD__);
    debug_to_log($e->GetMessage());
}
// EOF
?>
