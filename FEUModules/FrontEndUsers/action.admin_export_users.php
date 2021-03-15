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
$this->SetCurrentTab('users');

$offset = 0;
$batchsize = 50;
$count = $db->GetOne('SELECT COUNT(DISTINCT u.id) FROM '.cms_db_prefix().'module_feusers_users u');
if( $count == 0 ) {
  $this->SetError($this->Lang('error_export_nousers'));
  $this->RedirectToTab();
}
$uquery = 'SELECT DISTiNCT u.id,u.username,u.expires,u.createdate
           FROM '.cms_db_prefix().'module_feusers_users u ORDER BY u.id';

$groups = array_flip($this->GetGroupList());
$propdefns = $this->GetPropertyDefns();
$relns = array();
foreach( $groups as $gid => $gname ) {
  $relns[$gid] = $this->GetGroupPropertyRelations($gid);
}

// build the field map
$fieldmap = array('username'=>null,'expires'=>null,'createdate'=>null,'groupname'=>null);
foreach( $relns as $gid => $reln_list ) {
    foreach( $reln_list as $reln ) {
        if( !isset($propdefns[$reln['name']]) ) continue;
        if( $propdefns[$reln['name']]['type'] == 9 ) continue;  // no data fields
        if( $reln['required'] == 2 || $reln['required'] == 1 || $reln['required'] == 3 ) $fieldmap[$reln['name']] = null;
    }
}

// clear all buffers
// export the header line
$fn="feusers-".date('Y-m-d').'.csv';
$header = '##'.implode(',',array_keys($fieldmap));
$handlers = ob_list_handlers();
for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }
header('Content-Description: File Transfer');
header('Content-Type: application/force-download');
header('Content-Disposition: attachment; filename='.$fn);
echo $header."\n";

while( $offset < $count ) {
    $dbr_u = $db->SelectLimit($uquery,$batchsize,$offset);

    // get the user ids.
    $uids = array();
    while( !$dbr_u->EOF() ) {
        $tmp = (int)$dbr_u->fields['id'];
        if( $tmp > 0 && !in_array($tmp,$uids) ) $uids[] = $tmp;
        $dbr_u->MoveNext();
    }
    $dbr_u->MoveFirst();

    // get the belongs stuff for these users
    $bquery = 'SELECT userid,groupid FROM '.cms_db_prefix().'module_feusers_belongs
             WHERE userid IN ('.implode(',',$uids).') ORDER BY userid,groupid';
    $tmp = $db->GetArray($bquery);
    $belongs = array();
    foreach( $tmp as $brow ) {
        if( !isset($belongs[$brow['userid']]) ) $belongs[$brow['userid']] = array();
        $belongs[$brow['userid']][] = $brow['groupid'];
    }

    // get the properties for these users
    $pquery = 'SELECT * FROM '.cms_db_prefix().'module_feusers_properties
             WHERE userid IN ('.implode(',',$uids).') ORDER BY userid,title';
    $tmp = $db->GetArray($pquery);
    $properties = array();
    foreach( $tmp as $prow ) {
        if( !isset($properties[$prow['userid']]) ) $properties[$prow['userid']] = array();
        $properties[$prow['userid']][$prow['title']] = $prow['data'];
    }

    while( !$dbr_u->EOF() ) {
        // add primary fields
        $uid = $dbr_u->fields['id'];
        $row = $fieldmap;
        $row['username'] = $dbr_u->fields['username'];
        $row['expires'] = $dbr_u->fields['expires'];
        $row['createdate'] = $dbr_u->fields['createdate'];

        // add groupname(s)
        if( isset($belongs[$uid]) ) {
            $tmp = array();
            foreach( $belongs[$uid] as $gid ) {
                if( isset($groups[$gid]) ) $tmp[] = $groups[$gid];
            }
            $row['groupname'] = implode(',',$tmp);
        }

        // add properties
        if( isset($properties[$uid]) ) {
            foreach( $properties[$uid] as $pname => $pval ) {
                if( !array_key_exists($pname,$row) ) continue;
                $defn = $propdefns[$pname];
                // process field vals for outut.
                if( $defn['type'] == 3 ) {
                    $pval = str_replace("\r",'', $pval);
                    $pval = str_replace("\n",'\n',$pval);
                }
                $row[$pname] = $pval;
            }
        }
        $dbr_u->MoveNext();

        // output the row.
        echo cge_array::implode_quoted(array_values($row))."\n";
    }
    $offset += $batchsize;
} // while

exit();

#
# EOF
#
