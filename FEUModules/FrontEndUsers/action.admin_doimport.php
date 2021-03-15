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
$handlers = ob_list_handlers();
for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }
if( !$this->have_users_perm() ) exit;
$file = cge_utils::get_param($params,'file');
if( !$file ) exit;
$file = TMP_CACHE_LOCATION."/$file";
if( !is_readable($file) ) exit;
$now = time();

$imageDir = $this->config['uploads_path'].'/'.$this->get_settings()->image_destination_path;

$tmp = $this->CGGetPreference('importprefs');
if( !$tmp ) exit;
$importprefs = unserialize($tmp);

$progress_max = function($val) {
    $val = (int)$val;
    $val = max(1,$val);
    echo '<script type="text/javascript">parent.import_progress_max('.$val.');</script>';
    flush();
};
$progress_set = function($val) {
    $val = (int)$val;
    $val = max(1,$val);
    echo '<script type="text/javascript">parent.import_progress_set('.$val.');</script>';
    flush();
};
$import_status = function($msg) {
    $msg = trim($msg);
    if( !$msg ) return;
    echo '<script type="text/javascript">parent.import_status(\''.$msg.'\');</script>';
    flush();
};
$import_warning = function($msg) {
    $msg = trim($msg);
    if( !$msg ) return;
    echo '<script type="text/javascript">parent.import_warning(\''.$msg.'\');</script>';
    flush();
};
$import_error = function($msg) {
    $msg = trim($msg);
    if( !$msg ) return;
    echo '<script type="text/javascript">parent.import_error(\''.$msg.'\');</script>';
    flush();
};
$import_error_line = function($linenum,$msg) {
    $linenum = (int)$linenum;
    $msg = trim($msg);
    if( !$msg ) return;
    echo '<script type="text/javascript">parent.import_error(\''.$linenum.': '.$msg.'\');</script>';
    flush();
};
$import_finish = function() {
    echo '<script type="text/javascript">parent.import_finish();</script>';
    flush();
};
$import_log = function(string $str) {
    echo '<script type="text/javascript">console.log(\''.$str.'\')</script>';
    flush();
};
$clean_fields = function($the_array) {
    foreach( $the_array as &$elem ) {
        $elem = trim(trim($elem,'"\''));
    }
    return $the_array;
};
$get_field = function($columns,$fieldmap,$field) {
    if( !$field ) throw new Exception('Invalid field specified '.$field);
    $idx = array_search($field,$fieldmap);
    if( $idx === FALSE ) return;
    if( isset($columns[$idx]) ) return $columns[$idx];
};
$all_columns_empty = function($columns) {
    foreach( $columns as $col ) {
        if( $col ) return FALSE;
    }
    return TRUE;
};

try {
    $filesize = filesize($file);
    $fh = fopen($file,'r');
    $line_num = $processed_lines = $have_header = $fieldmap = null;
    $groups = $this->GetGroupList();
    $propdefns = $this->GetPropertyDefns();
    $relns = array();
    foreach( $groups as $gname => $gid ) {
        $relns[$gname] = $this->GetGroupPropertyRelations($gid);
    }
    $tmp = max(1,$this->get_settings()->expireage_months);
    $dflt_expiry = strtotime(sprintf('+ %d months',$tmp));
    $dflt_password = 'changeme';
    $error_users = array();
    $all_users = null;
    {
        $query = new feu_user_query();
        $rs = $query->execute();
        while( !$rs->EOF ) {
            $flds = $rs->fields;
            $all_users[$flds['username']] = $flds['id'];
            $rs->MoveNext();
        }
    }
    $touched_gids = $touched_uids = array();

    $import_log('test123');
    $progress_max($filesize);
    while( !feof($fh) ) {
        set_time_limit(30);
        $progress_set(ftell($fh));
        $rec = fgetcsv($fh);
        $line_num++;

        if( !is_array($rec) || !count($rec) ) continue;

        $processed_lines++;
        if( $processed_lines == 1 ) {
            //
            // process the header
            //
            if( !startswith($rec[0],'##') ) throw new Exception($this->Lang('error_importfileformat'));
            $fieldmap = $rec;
            $fieldmap[0] = substr($fieldmap[0],2);
            $fieldmap = $clean_fields($fieldmap);
            if( !in_array('username',$fieldmap) ) throw new Exception($this->Lang('error_importrequiredfield','username'));
            if( !in_array('groupname',$fieldmap) ) throw new Exception($this->Lang('error_importrequiredfield','groupname'));
            continue;
        }

        //
        // processing a data line
        //
        $columns = $clean_fields($rec);
        if( $all_columns_empty($columns) ) continue;

        if( count($columns) < count($fieldmap) - 1 || count($columns) > count($fieldmap) ) {
            $import_error_line($line_num,$this->Lang('error_import_columncount'));
            continue;
        }
        if( count($columns) < array_search('username',$fieldmap) ) {
            $import_error_line($line_num,$this->Lang('error_import_columncount'));
            continue;
        }

        $import_log('import got past test1');
        // get the user rec.
        $user = ['username'=>null, 'password'=>null, 'gname'=>null, 'expires'=>null, 'createdate'=>null, 'props'=>[]];
        $user['username'] = $get_field($columns,$fieldmap,'username');
        $user['password'] = $get_field($columns,$fieldmap,'txtpassword');
        $user['createdate'] = $get_field($columns,$fieldmap,'createdate',$now);
        $user['expires'] = $get_field($columns,$fieldmap,'expires',$now);
        $gnames = $get_field($columns,$fieldmap,'groupname');
        if( !$gnames ) {
            $import_error_line($line_num,$this->Lang('error_importgroupname',$gname));
            continue;
        }
        $gnames = $clean_fields(explode(',',$gnames));
        try {
            foreach( $gnames as $gname ) {
                if( !isset($groups[$gname]) ) throw new Exception($this->Lang('error_importgroupname',$gname));
                if( !isset($relns[$gname]) ) throw new Exception($this->Lang('error_importgroupname',$gname));

                foreach( $relns[$gname] as $reln ) {
                    // make sure the required fields for this group are available in the field map
                    if( $reln['required'] == 2 && !in_array($reln['name'],$fieldmap) ) {
                        throw new Exception($this->Lang('error_importrequiredfield',$reln['name']));
                    }
                    // add the field to the user rec
                    $tmp = $get_field($columns,$fieldmap,$reln['name']);
                    if( $tmp ) $user['props'][$reln['name']] = $tmp;
                }
            }
        }
        catch( Exception $e ) {
            $import_error_line($line_num,$e->GetMessage());
            if( $user['username'] ) $error_users[] = $user['username'];
            continue;
        }

        // validate the user rec.
        if( !cge_utils::get_param($user,'username') ) {
            $import_error_line($line_num,$this->Lang('error_importrequiredfield','username'));
            continue;
        }
        if( !$this->IsValidUsername($user['username']) ) {
            $import_error_lone($line_num,$this->Lang('error_importfieldvalue','username'));
            continue;
        }
        if( !cge_utils::get_param($user,'createdate') ) $user['createdate'] = $now;
        if( !is_int($user['createdate']) ) $user['createdate'] = strtotime($user['createdate']);
        if( !is_int($user['expires']) ) $user['expires'] = strtotime($user['expires']);
        // yep, again.
        if( !cge_utils::get_param($user,'createdate') ) $user['createdate'] = $now;
        if( !cge_utils::get_param($user,'expires') ) $user['expires'] = $dflt_expiry;
        try {
            foreach( $gnames as $gname ) {
                foreach( $relns[$gname] as $reln ) {
                    $val = cge_utils::get_param($user['props'],$reln['name']);
                    if( $reln['required'] == 2 && !$val ) {
                        // this validates that a required field for our destination group is filled in
                        throw new Exception($this->Lang('error_importrequiredfield',$reln['name']));
                    }
                    if( $val ) {
                        // we have a value for this property
                        // if the property is a dropdown or multiselect, make sure the value is valid.
                        switch( $propdefns[$reln['name']]['type'] ) {
                        case $this::FIELDTYPE_TEXTAREA:
                            // convert \n string back to linefeeds.
                            $val = str_replace('\n',"\n",$val);
                            $user['props'][$reln['name']] = $val;
                            break;

                        case $this::FIELDTYPE_DATE:
                            if( is_int($val) && $val < 0 ) {
                                throw new Exception($this->Lang('error_importfieldvalue',$reln['name']));
                            }
                            else if( strtotime($val) < 1 ) {
                                throw new Exception($this->Lang('error_importfieldvalue',$reln['name']));
                            }
                            break;

                        case $this::FIELDTYPE_EMAIL:
                            if( !is_email($val) ) throw new Exception("$val id not a valid email address");
                            if( !is_email($val) ) throw new Exception($this->Lang('error_importfieldvalue',$reln['name']));
                            break;

                        case $this::FIELDTYPE_IMAGE:
                            // just ensure that the image exists.
                            $filespec = $imageDir.'/'.$val;
                            if( !file_exists($filespec) ) throw new Exception($this->Lang('error_importfieldvalue',$reln['name']));
                            break;

                        case $this::FIELDTYPE_MULTISELECT:
                            $opts = array_flip($this->GetSelectOptions($reln['name']));
                            $vals = $clean_fields(explode(',',$val));
                            foreach( $vals as $oneval ) {
                                if( !isset($opts[$oneval]) ) throw new Exception($this->Lang('error_importfieldvalue',$reln['name']));
                            }
                            break;

                        case $this::FIELDTYPE_DROPDOWN:
                        case $this::FIELDTYPE_RADIOBUTNS:
                            $opts = array_flip($this->GetSelectOptions($reln['name']));
                            if( !isset($opts[$val]) ) throw new Exception($this->Lang('error_importfieldvalue',$reln['name']));
                            break;
                        }
                    }
                }
            }
        }
        catch( Exception $e ) {
            $import_error_line($line_num,$e->GetMessage());
            if( $user['username'] ) $error_users[] = $user['username'];
            continue;
        }

        // do the add or update.
        $uid = null;
        if( isset($all_users[$user['username']]) ) {
            // update the user.
            $uid = $all_users[$user['username']];
            $tmp = $this->SetUser($uid,$user['username'],$user['password'],$user['expires']);
            if( !is_array($tmp) || $tmp[0] === FALSE ) {
                $import_error_line($line_num,$this->Lang('error_importupdateuser',$tmp[1]));
                continue;
            }
            if( $user['createdate'] && $user['createdate'] < ($now - 90) ) {
                $sql = 'UPDATE '.cms_db_prefix().'module_feusers_users SET createdate = ? WHERE id = ?';
                $tmp = trim($db->DbTimeStamp($user['createdate']),"'");
                $db->Execute($sql, [ $tmp, $uid ] );
            }
            $gidlist = array();
            foreach( $gnames as $gname ) {
                $gidlist[] = $groups[$gname];
                if( !in_array($groups[$gname],$touched_gids) ) $touched_gids[] = $groups[$gname];
            }
            $this->SetUserGroups($uid,$gidlist);
            $this->SetUserProperties($uid,$user['props']);
            $import_status('updated user '.$user['username']);
        }
        else {
            // insert the user
            if( !cge_utils::get_param($user,'password') ) $user['password'] = $dflt_password;
            if( !cge_utils::get_param($user,'expires') ) $user['expires'] = $dflt_expiry;
            $tmp = $this->AddUser($user['username'],$user['password'],$user['expires']);
            if( !is_array($tmp) || $tmp[0] === FALSE ) {
                $import_error_line($line_num,$this->Lang('error_importinsertuser',$tmp[1]));
                continue;
            }
            $uid = (int) $tmp[1];
            if( $user['createdate'] && $user['createdate'] < ($now - 90) ) {
                $sql = 'UPDATE '.cms_db_prefix().'module_feusers_users SET createdate = ? WHERE id = ?';
                $tmp = trim($db->DbTimeStamp($user['createdate']),"'");
                $db->Execute($sql, [ $tmp, $uid ] );
            }
            $gidlist = array();
            foreach( $gnames as $gname ) {
                $gidlist[] = $groups[$gname];
            }
            $this->SetUserGroups($uid,$gidlist);
            $this->SetUserProperties($uid,$user['props']);
            $import_status('created user '.$user['username']);
            // todo: status msg
        }

        // set progress
        $progress_set(ftell($fh));

        // set the user
        if( $uid && !in_array($uid,$touched_uids) ) $touched_uids[] = $uid;

        // delete the user from the complete user list.
        unset($all_users[$user['username']]);

    } // feof

    // delete users who are member of the imported group, (assuming we only listed one group) but
    // not listed in this list.
    $touched_uids = array_unique($touched_uids);
    if( count($touched_gids) == 1 && count($touched_uids) && $importprefs['delete_users'] ) {
        // gotta get the uids of all of the users in this group.
        $query = new feu_user_query();
        $query->add_and_opt(feu_user_query_opt::MATCH_GROUPID,$touched_gids[0]);
        $rs = $query->execute();
        $del_uids = array();
        while( !$rs->EOF() ) {
            if( !in_array($rs->fields['id'],$touched_uids) && !in_array($rs->fields['id'],$del_uids) ) {
                $del_uids[] = $rs->fields['id'];
            }
            $rs->MoveNext();
        }

        // gotta delete remaining users
        if( count($del_uids) ) {
            $progress_max(count($del_uids));
            $n = 0;
            foreach( $del_uids as $uid ) {
                set_time_limit(20);
                if( $uid > 0 ) {
                    $this->DeleteUserFull( $uid );
                    $import_status($this->Lang('import_deleteduser',$uid));
                }
                $n++;
                $progress_set($n);
            }
        }
    }

    $import_finish();
}
catch( Exception $e ) {
    $import_error($e->GetMessage());
}
exit;

#
# EOF
#
?>
