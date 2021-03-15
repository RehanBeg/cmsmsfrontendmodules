<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management of frontend
#  users, and their login process within a CMS Made Simple powered
#  website.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This projects homepage is: http://www.cmsmadesimple.org
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
use FrontEndUsers;
use feu_user_query;
use cms_cookies;
use cms_cache_handler;
use cge_utils;
use cge_array;
use CMSMS\HookManager;
use feu_utils;

abstract class FrontEndUsersManipulator extends UserManipulator
{
    /**
     * @ignore
     */
    protected function keepalive_cookie()
    {
        return 'ka'.sha1(__FILE__);
    }

    /**
     * @internal
     */
    protected function encode_userdata(array $data)
    {
        $str = json_encode($data);
        $str .= '::'.sha1($str.__FILE__);
        return base64_encode($str);
    }

    private function decode_userdata(string $str)
    {
        $encoded = base64_decode($str);
        if( !$encoded ) return;
        list($json,$sig) = explode('::',$encoded,2);
        if( !$json || !$sig ) return;
        if( sha1($json.__FILE__) != $sig ) return;
        return json_decode($json,TRUE);
    }

    private function get_bad_salt()
    {
        // this method should only be used for sites that have been upgraded forever
        // and its use is very bad for security, as it implies a shared salt on user passwords.
        $mod = $this->GetModule();
        $salt = $mod->GetPreference('pwsalt','');
        if( !$salt ) audit('','FrontEndUsers','IMPORTANT We are using bad password hashing... and even worse the salt is empty');
        return $salt;
    }

    private function get_expireusers_lastrun()
    {
        return cms_cache_handler::get_instance()->set('expire_lastrun',__CLASS__);
    }

    private function touch_expireusers_lastrun()
    {
        cms_cache_handler::get_instance()->set('expire_lastrun',time(),__CLASS__);
    }

    /** deprecated -- move to upgrade routine **/
    protected function GetEncryptionKey($uid = -1)
    {
        // needed for encrypted properties
        global $CMS_ADMIN_PAGE;
        $mod = $this->GetModule();

        if( $CMS_ADMIN_PAGE ) {
            // an administrator can see encrypted data.
            if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
            $res = $this->get_user($uid);
            if( !$res ) return;
            $key = md5($mod->config['root_url'].$uid.$res['createdate'].$this->get_bad_salt());
            return $key;
        }
        else {
            // frontend request... use logged in id.
            $tuid = $this->LoggedInId();
            if( $tuid < 1 ) return;

            $res = $this->get_user($uid);
            if( !$res ) return;

            $key = md5($mod->config['root_url'].$tuid.$res['createdate'].$this->get_bad_salt());
            return $key;
        }

        return FALSE;
    }

    public function RemoveUserTempCode(int $uid) : bool
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $db = $this->GetDb();
        try {
            $uid = (int) $uid;
            $db->BeginTrans();
            $q = "DELETE FROM ".CMS_DB_PREFIX."module_feusers_tempcode WHERE userid = ?";
            $db->Execute( $q, array( $uid ) );
            $db->CommitTrans();
            return TRUE;
        }
        catch( \Exception $e ) {
            $db->RollbackTrans();
            $mod = $this->GetModule();
            audit($uid,$mod->GetName(),'Could remove temp code');
            cge_utils::log_exception($e);
            return FALSE;
        }
    }

    protected function GetLastUserTempCode(int $uid)
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $db = $this->GetDb();
        $q = "SELECT * FROM ".CMS_DB_PREFIX."module_feusers_tempcode WHERE userid = ? ORDER BY created DESC";
        $dbresult = $db->GetRow( $q, array( $uid ));
        if( is_array($dbresult) && count($dbresult) ) return $dbresult['code'];
    }

    public function VerifyUserTempCode(int $uid, string $code) : bool
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $code = trim($code);
        if( !$code ) throw new \InvalidArgumentException('invalid code passed to '.__METHOD__);
        $db = $this->GetDb();

        $parms = [ $uid, $code ];
        $sql = 'SELECT * FROM '.CMS_DB_PREFIX.'module_feusers_tempcode WHERE userid = ? AND code = ?';
        if( ($days = $this->GetSettings()->tempcode_expiry_days > 0) ) {
            $time = min(365,$days) * 24 * 3600;
            $sql .= ' AND created > ?';
            $parms[] = $time;
        }
        $row = $db->GetRow( $sql, $parms );
        if( !$row ) return false;
        return true;
    }

    public function SetUserTempCode(int $uid, string $code) : bool
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $code = trim($code);
        if( !$code ) throw new \InvalidArgumentException('invalid code passed to '.__METHOD__);
        $db = $this->GetDb();

        try {
            $q = "INSERT INTO ".CMS_DB_PREFIX."module_feusers_tempcode VALUES(?,?,NOW())";
            $db->Execute( $q, array( $uid, $code ) );
            return TRUE;
        }
        catch( \Exception $e ) {
            audit($uid,'FrontEndusers','Could set temp code');
            cge_utils::log_exception($e);
            return FALSE;
        }
    }

    public function SetPropertyDefn(string $name,string $newname,string $prompt,int $length,int $type,
                                    int $maxlength = 0,string $attribs = null,bool $force_unique = false) : bool
    {
        $name = trim($name);
        if( !$name ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $db = $this->GetDb();
        if( $maxlength == 0 ) $maxlength = $length;
        $q = "UPDATE ".CMS_DB_PREFIX."module_feusers_propdefn
              SET name = ?, prompt = ?, type = ?, length = ?, maxlength = ?, attribs = ?, force_unique = ?
              WHERE name = ?";
        $dbresult = $db->Execute( $q, array( $newname, $prompt, $type, $length, $maxlength, $attribs, $force_unique, $name ));
        if( !$dbresult ) return false;
        return true;
    }

    public function DeletePropertyDefn(string $name) : bool
    {
        $name = trim($name);
        if( !$name ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $db = $this->GetDb();
        try {
            $db->BeginTrans();
            $this->DeleteSelectOptions($name);

            $q = 'DELETE FROM '.CMS_DB_PREFIX.'module_feusers_properties WHERE title = ?';
            $db->Execute($q,array($name));

            $query = 'SELECT group_id,sort_key FROM '.CMS_DB_PREFIX.'module_feusers_grouppropmap WHERE name = ?';
            $dbr = $db->GetArray($query,array($name));

            if( is_array($dbr) && count($dbr) ) {
                $q = 'UPDATE '.CMS_DB_PREFIX.'module_feusers_grouppropmap
                          SET sort_key = sort_key - 1
                          WHERE group_id = ? AND sort_key > ?';
                foreach( $dbr as $row ) {
                    $db->Execute($query,array($row['group_id'],$row['sort_key']));
                }
            }

            $q = 'DELETE FROM '.CMS_DB_PREFIX.'module_feusers_grouppropmap WHERE name = ?';
            $db->Execute($q,array($name));

            $q = "DELETE FROM ".CMS_DB_PREFIX."module_feusers_propdefn WHERE name=?";
            $db->Execute( $q, array( $name ) );

            $db->CommitTrans();
            return true;
        }
        catch( \Exception $e ) {
            $db->RollbackTrans();
            $mod = $this->GetModule();
            audit('',$mod->GetName(),'Could not delete property '.$name);
            cge_utils::log_exception($e);
            return FALSE;
        }

    }


    public function GetPropertyGroupRelations(string $title)
    {
        $title = trim($title);
        if( !$title ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $db = $this->GetDb();

        $q = "SELECT * FROM ".CMS_DB_PREFIX."module_feusers_grouppropmap WHERE name = ? ORDER BY sort_key DESC";
        $dbresult = $db->Execute( $q, array( $title ) );
        if( !$dbresult ) return;
        $result = array();
        while( $row = $dbresult->FetchRow() ) {
            $result[] = $row;
        }
        return $result;
    }


    /**
     * Return the unix timestamp of the users expiry date
     * or false;
     *
     * @return string
     */
    public function GetExpiryDate(int $uid)
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $res = $this->get_user($uid);
        if( $res ) return $res->expires;
    }

    public function IsAccountDisabled(int $uid) : bool
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $res = $this->get_user($uid);
        if( $res ) return $res->disabled;
    }

    public function IsAccountExpired(int $uid) : bool
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $res = $this->get_user($uid);
        if( $res ) return $res->expired;
    }

    public function GetGroupPropertyRelations(int $grpid) : array
    {
        if( $grpid < 1 ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $db = $this->GetDb();
        $q = "SELECT * FROM ".CMS_DB_PREFIX."module_feusers_grouppropmap ORDER BY group_id ASC,sort_key ASC";
        $list = $db->GetArray($q);
        if( !$list ) return [];

        $res = [];
        for( $i = 0, $n = count($list); $i < $n; $i++ ) {
            $row = $list[$i];
            if( $row['group_id'] < $grpid ) continue;
            if( $row['group_id'] > $grpid ) break;

            $res[] = $row;
        }
        if( !count($res) ) return [];

        return $res;
    }

    public function GetMultiGroupPropertyRelations(array $grouplist = null) : array
    {
        // user is a member of one or more groups, and we need to change property values
        // so somehow we order the properties in all of the groups, first by the sort key
        // then by the required status, then by the name.
        $array_merge_by_name_required = function(array $arr1, array $arr2) {
            $prefilter = function(array $rec) {
                if( isset($rec['name']) && isset($rec['required']) ) return true;
            };

            $arr1 = array_filter($arr1,$prefilter);
            $arr2 = array_filter($arr2,$prefilter);
            $tmp = array_merge($arr1, $arr2);
            // sort by name, then required
            usort($tmp,function($a,$b){
                    $x = $a['sort_key'] - $b['sort_key'];
                    if( $x != 0) return $x;
                    $x = $b['required'] - $a['required'];
                    if( $x != 0) return $x;
                    $x = strcmp($a['name'],$b['name']);
                    return $x;
                });
            // remove duplicate names
            $have = [];
            $tmp = array_filter($tmp,function($item) use (&$have) {
                    $name = $item['name'];
                    if( !in_array($name,$have) ) {
                        $have[] = $name;
                        return true;
                    } else {
                        return false;
                    }
                });
            return $tmp;
        };

        $out = [];
        if( empty($grouplist) ) return $out;
        foreach( $grouplist as $gid ) {
            $gid = (int) $gid;
            if( $gid < 1 ) throw new \InvalidArgumentException('Invalid parameters passed to '.__METHOD__);

            $relations = $this->GetGroupPropertyRelations( $gid );
            if( !empty($relations ) ) $out = $array_merge_by_name_required($out, $relations);
        }
        return $out;
    }

    public function AddGroupPropertyRelation(int $grpid, string $propname, int $sortkey, int $required) : array
    {
        if( $grpid < 1 ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        if( !$propname ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        if( $sortkey < 0 ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);

        $db = $this->GetDb();

        $q = "INSERT INTO ".CMS_DB_PREFIX."module_feusers_grouppropmap (name, group_id, sort_key, required) VALUES(?,?,?,?)";
        $dbresult = $db->Execute( $q, [ $propname, $grpid, $sortkey, $required ]);
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());
        return array(TRUE);
    }

    public function DeleteAllGroupPropertyRelations(int $grpid) : array
    {
        if( $grpid < 1 ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $db = $this->GetDb();
        try {
            $db->BeginTrans();
            $q = "DELETE FROM ".CMS_DB_PREFIX."module_feusers_grouppropmap WHERE group_id = ?";
            $db->Execute( $q, array( $grpid ));
            $db->CommitTrans();
            return array(TRUE);
        }
        catch( \Exception $e ) {
            $db->RollbackTrans();
            $mod = $this->GetModule();
            audit('',$mod->GetName(),'Could not delete all group property relations');
            cge_utils::log_exception($e);
            return array(FALSE,$e->GetMessage());
        }
    }

    public function AddPropertyDefn(string $name, string $prompt, int $type, int $length,
                                    int $maxlength = 0, string $attribs = '', bool $force_unique = false) : array
    {
        if( !$name ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        if( $type < 0 || $type > 10 ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $db = $this->GetDb();
        if( $maxlength == 0 ) $maxlength == $length;

        $p = array( $name, $prompt, $type, $length, $maxlength, $attribs, $force_unique );
        $q = "INSERT INTO ".CMS_DB_PREFIX."module_feusers_propdefn
          (name,prompt,type,length,maxlength,attribs,force_unique)
          VALUES (?,?,?,?,?,?,?)";
        $dbresult = $db->Execute( $q, $p );
        if( $dbresult == false ) return array(FALSE, $db->sql.'<br/>'.$db->ErrorMsg());
        $new_id = $db->Insert_ID();

        return array(TRUE);
    }

    /*
    public function SetPropertyDefnExtra($name,$extra)
    {
        if( is_array($extra) ) $extra = serialize($extra);
        $db = $this->GetDb();
        $query = 'UPDATE '.CMS_DB_PREFIX.'module_feusers_propdefn SET extra = ? WHERE name = ?';
        $dbr = $db->Execute($query,array($extra,$name));
    }
    */

    public function AddSelectOptions(string $name, array $options) : array
    {
        if( !$name ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $db = $this->GetDb();
        try {
            $insert_vals = '';
            $order_id = 0;
            $sql = 'INSERT INTO '.CMS_DB_PREFIX.'module_feusers_dropdowns (order_id, option_name, option_text, control_name) VALUES (?,?,?,?)';
            $db->BeginTrans();
            foreach ($options as $opttext){
                // if no actual text in the line, make sure it equals '',
                // in order not to add it to the db
                $opttext = trim($opttext);
                if( $opttext == '' || $opttext == '__' ) continue;

                $optname = trim($opttext);
                if( strchr( $opttext, '=' ) !== FALSE ) {
                    $tmp = explode('=',$opttext,2);
                    $optname = trim($tmp[1]);
                    $opttext = trim($tmp[0]);
                }

                $order_id++;
                $res = $db->Execute( $sql, [ $order_id, $optname, $opttext, $name ]);
                if( !$res ) throw new \Exception('SQL ERROR: '.$db->ErrorMsg());
            }
            $db->CommitTrans();
            return [TRUE];
        }
        catch( \Exception $e ) {
            $db->RollbackTrans();
            $mod = $this->GetModule();
            audit('',$mod->GetName(),'Could expire temp codes ');
            cge_utils::log_exception($e);
            return [FALSE];
        }
    }

    public function DeleteSelectOptions(string $name) : array
    {
        if( !$name ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $db = $this->GetDb();
        $q = "DELETE FROM ".CMS_DB_PREFIX."module_feusers_dropdowns WHERE control_name = ?";
        $dbresult = $db->Execute( $q, array( $name ) );
        if( $dbresult == false ) return array(FALSE,$db->ErrorMsg());
        return array(TRUE);
    }

    public function GetPropertyDefn(string $name)
    {
        if( !$name ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $list = $this->GetPropertyDefns();
        return $list[$name] ?? null;
    }

    public function GetPropertyDefns()
    {
        $db = $this->GetDb();
        $query = 'SELECT * FROM '.CMS_DB_PREFIX.'module_feusers_propdefn';
        $data = $db->GetArray($query);
        if( !$data ) return;

        $out = null;
        for( $i = 0; $i < count($data); $i++ ) {
            if( !empty($data[$i]['extra']) && !is_null($data[$i]['extra']) ) $data[$i]['extra'] = @unserialize($data[$i]['extra']);
            if( !empty($data[$i]['attribs']) ) {
                $data[$i]['extra'] = unserialize($data[$i]['attribs']);
                unset($data[$i]['attribs']);
            }
            $out[$data[$i]['name']] = $data[$i];
        }
        return $out;
    }

    /**
     * Returns select options as a simple or a 2 dimensional array
     *
     * @param String $controlname - name of the dropdown as in the propdefn table
     * @param int $dim - dimension of the array
     * 	if $dim == 1, returns a 1 dimensional array text=>name
     *    if $dim == 2, returns a 2 dimensional array, each item being an
     * 		array with properties 'option_name', 'option_text', 'control_name'.
     *
     */
    public function GetSelectOptions(string $controlname, int $dim=1)
    {
        if( !$controlname ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $db = $this->GetDb();
        $q = "SELECT * FROM ".CMS_DB_PREFIX."module_feusers_dropdowns ORDER BY order_id";
        $dbr = $db->GetArray($q);
        if( !$dbr ) return;

        $ret = null;
        for( $i = 0; $i < count($dbr); $i++ ) {
            $row = $dbr[$i];

            if( $row['control_name'] == $controlname ) {
                if( $dim == 2 ) {
                    $ret[] = $row;
                }
                else {
                    $ret[trim($row['option_text'])] = trim($row['option_name']);
                }
            }
        }
        return $ret;
    }

    // userid api method
    // returns true/false
    public function AssignUserToGroup(int $uid,int $gid) : bool
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        if( $gid < 1 ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $uid = (int) $uid;
        $gid = (int) $gid;
        if( $uid < 1 || $gid < 1 ) return false;
        // validate the user id
        if( !$this->UserExistsByID( $uid ) ) return false;

        // validate the group id
        if( !$this->GetGroupInfo($gid) ) return false;

        $db = $this->GetDb();
        // make sure it already doesn't exist
        $q = 'SELECT * FROM '.CMS_DB_PREFIX.'module_feusers_belongs WHERE userid = ? AND groupid = ?';
        $tmp = $db->GetRow($q,array($uid,$gid));
        if( $tmp ) return true;

        // add the record to the table to make this
        // user a member of this group
        $q = "INSERT INTO ".CMS_DB_PREFIX."module_feusers_belongs (userid, groupid) VALUES (?,?)";
        $dbresult = $db->Execute( $q, array( $uid, $gid ) );
        return( $dbresult != false );
    }

    // userid api method
    // returns true/false
    public function IsValidPassword(string $password) : bool
    {
        // a password is valid, if it's length is
        // within certain ranges
        $module = $this->GetModule();
        $minlen = $this->GetSettings()->min_passwordlength;
        $maxlen = $this->GetSettings()->max_passwordlength;
        $enhancedpw = $this->GetSettings()->enhanced_passwords;
        $requiredchars = $this->GetSettings()->password_requiredchars;
        $len = strlen($password);
        if( $len < $minlen || $len > $maxlen ) {
            return FALSE;
        }
        if( $enhancedpw ) {
            if( !preg_match('#[A-Z]#',$password) ) return FALSE;
            if( !preg_match('#[0-9]#',$password) ) return FALSE;
            if( $requiredchars && strpbrk($password,$requiredchars) === FALSE ) return FALSE;
        }

        return TRUE;
    }

    // userid api method
    // returns an array
    public function DeleteUserFull(int $id) : array
    {
        if( $id < 1 ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $db = $this->GetDb();
        $in_trans = null;
        try {
            $res = $this->get_user($id);
            if( !$res ) return [FALSE,'User not found'];
            $username = $res->username;

            // log the user out
            $this->LogoutUser( $id );

            $db->BeginTrans();
            $in_trans = true;

            // delete user properties
            $this->DeleteAllUserPropertiesFull( $id );

            // delete user from groups
            $ret = $this->RemoveUserFromGroup( $id, -1 );
            if( $ret[0] == false ) throw new \RuntimeException('Problem removing user from group');

            // delete the user history
            $q = 'DELETE FROM '.CMS_DB_PREFIX.'module_feusers_history WHERE userid = ?';
            $dbresult = $db->Execute( $q, array( $id ) );

            // and delete anything from the tempcodes table too
            $q = "DELETE FROM ".CMS_DB_PREFIX."module_feusers_tempcode WHERE userid = ?";
            $dbresult = $db->Execute( $q, array( $id ) );

            // finally delete user record
            $q = "DELETE FROM ".CMS_DB_PREFIX."module_feusers_users WHERE id = ?";
            $dbresult = $db->Execute( $q, array( $id ) );

            $db->CommitTrans();
            return [ TRUE, '' ];
        }
        catch( \Exception $e ) {
            if( $in_trans ) $db->RollbackTrans();
            $mod = $this->GetModule();
            audit($id,$mod->GetName(),'Problem deleting user: '.$e->GetMessage());
            cge_utils::log_exception($e);
            return [ FALSE,$e->GetMessage() ];
        }
    }

    // userid api method
    // returns an array
    public function GetGroupInfo(int $gid)
    {
        if( $gid < 1 ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $ginfo = $this->GetGroupListFull();
        return $ginfo[$gid] ?? null;
    }

    /**
     * Return an array of user information
     *
     * @param array An array of integer user ids
     * @param booolean flag indicating wether to return property information
     * @return array of user info.  Or null.
     * @deprecated
    public function GetBulkUserInfo( $uids, $deep = TRUE )
    {
        $out = array();
        foreach( $uids as $one ) {
            $one = (int)$one;
            if( $one < 1 ) continue;
            if( is_array($t) ) $out[] = $t;
        }
        return $out;
    }
     */

    /*
     * @internal
     */
    public function create_user(array $in) : UserInterface
    {
        return new User($in);
    }

    /**
     * Get a user object, if it exists
     *
     * @param int $uid
     * @return User|null
     */
    public function get_user(int $uid)
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);

        $db = $this->GetDb();
        $sql = 'SELECT * FROM '.CMS_DB_PREFIX.'module_feusers_users WHERE id = ?';
        $row = $db->GetRow( $sql, [ $uid ] );
        if( !$row ) return;
        if( isset($row['extra']) && $row['extra'] ) $row['extra'] = json_decode($row['extra'],TRUE);

        $defns = $this->GetPropertyDefns();
        if( !empty($defns) ) {
            // get properties
            $sql = 'SELECT title, data FROM '.CMS_DB_PREFIX.'module_feusers_properties WHERE userid = ?';
            $props = $db->GetArray($sql, [ $uid ] );
            if( !empty($props) ) {
                foreach( $props as $prow ) {
                    $defn = (isset($defns[$prow['title']])) ? $defns[$prow['title']] : null;
                    $row['props'][$prow['title']] = $prow['data'];
                }
            }
        }

        // get member groups
        $sql = 'SELECT groupid FROM '.CMS_DB_PREFIX.'module_feusers_belongs WHERE userid = ?';
        $groups = $db->GetCol($sql, [ $uid ] );
        if( !empty($groups) ) $row['groups'] = $groups;

        $tmp = $this->GetLastUserTempCode( $uid );
        if( $tmp ) $row['verify_code'] = $tmp;
        return $this->create_user($row);
    }

    /**
     * @deprecated
     */
    public function GetUserInfo(int $uid) : array
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $user = $this->get_user($uid);
        if( !$user ) return [ FALSE, 'not found' ];
        return [ TRUE, $user ];
    }

    // userid api method
    // returns an array
    // second element of array may be an array
    public function GetUserInfoByName(string $username) : array
    {
        $username = trim($username);
        if( empty($username) ) throw new \InvalidArgumentException('Invalid username passed to '.__METHOD__);
        $uid = $this->GetUserID($username);
        if( $uid < 1 ) {
            $module = $this->GetModule();
            return [FALSE,$module->Lang('error_usernotfound')];
        }
        return $this->GetUserInfo($uid);
    }

    protected function GetUserInfoByProperty($propname,$propvalue = null)
    {
        // does this even get called.
        if( !$propname ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $module = $this->GetModule();
        $defns = $this->GetPropertyDefns();
        if( !is_array($defns) ) return array(FALSE,$module->Lang('error_dberror'));
        if( !isset($defns[$propname]) ) return array(FALSE,$module->Lang('error_dberror'));

        $db = $this->GetDb();
        $parms = array($propname);
        $query = 'SELECT userid FROM '.CMS_DB_PREFIX.'module_feusers_properties up WHERE up.title = ?';

        if( !is_null($propvalue) ) {
            $query .= ' AND data = ?';
            $parms[] = $propvalue;
        }
        $uid = $db->GetOne($query,$parms);
        if( !$uid ) return array(FALSE,$module->Lang('error_usernotfound'));

        return $this->GetUserInfo( $uid );
    }

    public function GetLoggedInUsers(int $not_active_since = null)
    {
        die('remove me '.__METHOD__);
        $db = $this->GetDb();

        $q = 'SELECT userid FROM '.CMS_DB_PREFIX.'module_feusers_loggedin';
        $qparms = array();
        if( $not_active_since ) {
            $q .= " WHERE lastused < ?";
            $qparms[] = $not_active_since;
        }

        $res = $db->GetCol($q,$qparms);
        return $res;
    }

    public function CountUsersInGroup($groupid) : int
    {
        if( $groupid < 1 ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $db = $this->GetDb();

        $q = '';
        $parms = array();
        if( $groupid == '' || $groupid < 0 ) {
            $q = "SELECT count(id) as num FROM ".CMS_DB_PREFIX."module_feusers_users WHERE coalesce(disabled,0) = 0";
        }
        else {
            $q = "SELECT count(id) as num FROM ".CMS_DB_PREFIX."module_feusers_users,".
                CMS_DB_PREFIX."module_feusers_belongs WHERE id=userid AND groupid = ? AND coalesce(disabled,0) = 0";
            $parms[] = $groupid;
        }

        $dbresult = $db->Execute( $q, $parms );
        if( !$dbresult ) return 0;

        $row = $dbresult->FetchRow();
        return (int) $row['num'];
    }

    public function LogoutUser(int $uid = null)
    {
        if( $uid < 1 ) throw new LoginException('Cannot determine a uid to logout');

        $sql = 'DELETE FROM '.$this->tokens_table_name().' WHERE uid = ?';
        $this->GetDb()->Execute($sql, [ $uid ] );
    }

    function LoggedInEmail()
    {
        $userid=$this->LoggedInId();
        return $this->GetEmail($userid);
    }

    public function GetEmail(int $uid)
    {
        if( $uid < 1) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD_);
        $info = $this->get_user($uid);
        if( $info ) {
            $module = $this->GetModule();
            if ($this->GetSettings()->username_is_email) {
                return $info->username;
            }
            else {
                $defns = $this->GetPropertyDefns();
                foreach( $defns as $name => $rec ) {
                    if( $rec['type'] == FrontEndUsers::FIELDTYPE_EMAIL && !empty($info['props'][$name]) ) return $info['props'][$name];
                }
            }
        }
    }

    public function GetPhone(int $uid)
    {
        if( $uid < 1) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD_);
        $info = $this->get_user($uid);
        if( $info ) {
            $defns = $this->GetPropertyDefns();
            foreach( $defns as $name => $rec ) {
                if( $rec['type'] == FrontEndUsers::FIELDTYPE_TEL && !empty($info['props'][$name]) ) return $info['props'][$name];
            }
        }
    }

    public function IsValidUsername(string $username, bool $check_existing = true, int $uid = -1) : bool
    {
        $minlen = $this->GetSettings()->min_usernamelength;
        $maxlen = $this->GetSettings()->max_usernamelength;
        if( strlen( $username ) < $minlen || strlen( $username ) > $maxlen ) return false;
        if ($this->GetSettings()->username_is_email) {
            if( !is_email($username) ) return false;
        }
        else if( !preg_match( '/^[a-zA-Z0-9\_\-\s\.\@\+]*$/', $username ) ) {
            return false;
        }

        if( $check_existing ) {
            $parms = $sql = null;
            if( $uid > 0 ) {
                $sql = 'SELECT id FROM '.CMS_DB_PREFIX.'module_feusers_users WHERE username = ? AND id != ?';
                $parms[] = $username;
                $parms[] = $id;
            } else {
                $sql = 'SELECT id FROM '.CMS_DB_PREFIX.'module_feusers_users WHERE username = ?';
                $parms[] = $username;
            }
            $tmp = $this->GetDb()->GetOne($sql, $parms);
            if( $tmp ) return false;
        }
        return true;
    }

    // userid api method
    // returns an array
    public function RemoveUserFromGroup(int $uid, int $gid) : array
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $uid = (int) $uid;
        $gid = (int) $gid;
        $db = $this->GetDb();
        try {
            $db->BeginTrans();
            $parms = array( $uid );
            $q = "DELETE FROM ".CMS_DB_PREFIX."module_feusers_belongs WHERE userid = ?";
            if( $gid > 0 ) {
                $q .= " AND groupid = ?";
                $parms[] = $gid;
            }
            $db->Execute( $q, $parms );
            $db->CommitTrans();
            return array( TRUE );
        }
        catch( \Exception $e ) {
            $db->RollbackTrans();
            $mod = $this->GetModule();
            audit($uid,$mod->GetName(),'Could not remove user from group '.$gid);
            cge_utils::log_exception($e);
            return array(FALSE,$e->GetMessage());
        }
    }


    // userid api method
    // returns array
    public function SetGroup(int $id,string $name,string $desc = null) : array
    {
        $id = (int) $id;
        $name = trim($name);
        $desc = trim($desc);
        if( $id < 1 || !$name ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $mod = $this->GetModule();

        $db = $this->GetDb();

        $eid = $this->GetGroupID( $name );
        if( $eid != false && $eid != $id ) {
            return array(FALSE,$mod->Lang('error_groupname_exists'));
        }

        $q = "UPDATE ".CMS_DB_PREFIX."module_feusers_groups SET groupname = ?, groupdesc = ? WHERE id = ?";
        $dbresult = $db->Execute( $q, array( $name, $desc, $id ) );
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());

        return array( TRUE );
    }

    protected function EncryptPassword( $uid, $plain_password )
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        /* should be protected */
        $use_usersalt = $this->use_usersalt();
        if( !$use_usersalt ) {
            // this is realy really bad.. but kept for old installs.
            audit('','FrontEndUsers','FEU is using unsafe password encryption');
            return md5($plain_password.$this->get_bad_salt());
        }
        else if( $use_usersalt == 1 ) {
            $db = $this->GetDb();
            $salt = $db->GetOne('SELECT salt FROM '.CMS_DB_PREFIX.'module_feusers_users WHERE id = ?',array($uid));
            if( !$salt ) throw new \LogicException('Using user salted passwords, but no salt set for this user (or the user could not be found)');
            return sha1($plain_password.$salt);
        }
        // use_usersalt == 2
        return password_hash($plain_password,PASSWORD_BCRYPT);
    }

    public function SetUserPassword(int $uid, string $password) : array
    {
        $uid = (int) $uid;
        $password = trim((string) $password);
        if( $uid < 1 || !$password ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $db = $this->GetDb();

        // going forward, we use no salt column.
        $pw = $this->EncryptPassword($uid,$password);
        $q = "UPDATE ".CMS_DB_PREFIX."module_feusers_users SET salt = NULL, password = ? WHERE id = ?";
        $dbresult = $db->Execute( $q, array( $pw, $uid ));
        if( !$dbresult ) return [FALSE,$db->ErrorMsg()];

        return array(TRUE);
    }

    // todo: add to UserManipulator
    public function SetUserDisabled(int $uid, bool $flag = TRUE )
    {
        $uid = (int) $uid;
        $flag = (bool) $flag;
        if( $uid < 1 ) throw new \LogicException('Invalid uid passed to '.__METHOD__);

        $db = $this->GetDb();
        $query = 'UPDATE '.CMS_DB_PREFIX.'module_feusers_users SET disabled = ? WHERE id = ?';
        $dbr = $db->Execute($query,array($flag,$uid));
        if( !$dbr ) throw new \LogicException('problem setting uid '.$uid.' to disabled');

        if( $flag ) $this->LogoutUser($uid);
    }

    // todo: add to UserManipulator
    public function ForcePasswordChange(int $uid, bool $flag = true)
    {
        $uid = (int) $uid;
        $flag = (bool) $flag;
        if( $uid < 1 ) throw new \LogicException('Invalid uid passed to '.__METHOD__);

        $db = $this->GetDb();
        $query = 'UPDATE '.CMS_DB_PREFIX.'module_feusers_users SET force_newpw = ? WHERE id = ?';
        $dbr = $db->Execute($query,array($flag,$uid));
        if( !$dbr ) throw new \LogicException('problem setting force_newpw flag for user '.$uid);
    }

    // todo: add to UserManipulator
    public function ForceChangeSettings(int $uid, bool $flag = TRUE)
    {
        $uid = (int) $uid;
        $flag = (bool) $flag;
        if( $uid < 1 ) throw new \LogicException('Invalid uid passed to '.__METHOD__);

        $db = $this->GetDb();
        $query = 'UPDATE '.CMS_DB_PREFIX.'module_feusers_users SET force_chsettings = ? WHERE id = ?';
        $dbr = $db->Execute($query,array($flag,$uid));
        if( !$dbr ) throw new \LogicException('problem setting force_chsettings flag for user '.$uid);
    }

    // todo: add to UserManipulator
    public function ForceVerify(int $uid, bool $flag = TRUE)
    {
        $uid = (int) $uid;
        $flag = (bool) $flag;
        if( $uid < 1 ) throw new \LogicException('Invalid uid passed to '.__METHOD__);

        $db = $this->GetDb();
        $query = 'UPDATE '.CMS_DB_PREFIX.'module_feusers_users SET must_validate = ? WHERE id = ?';
        $dbr = $db->Execute($query,array($flag,$uid));
    }

    // userid api method
    // returns array
    public function SetUser(int $uid,string $username,string $password,int $expires = null) : array
    {
        if( $uid < 1 ) throw new \LogicException('Invalid uid passed to '.__METHOD__);
        $username = trim($username);
        $db = $this->GetDb();
        $module = $this->GetModule();
        if( $uid < 1 ) throw new \LogicException('Invalid uid passed to '.__METHOD__);
        if( !$username ) throw new \LogicException('Invalid username passed to '.__METHOD__);

        // make sure that this user exists
        $ret = $this->get_user($uid);
        if( !$ret ) return [FALSE, 'User not found'];

        // make sure that this username is not taken by some other id
        $nuid = $this->GetUserID($username);
        if( $nuid != false && $nuid != $uid ) return array(FALSE, $module->Lang('error_usernametaken',$uid));

        $dbresult = '';
        $parms = array();
        $q = "UPDATE ".CMS_DB_PREFIX."module_feusers_users SET username = ?";
        $parms[] = $username;

        if($expires > 0) {
            $q .= ", expires = ?";
            $parms[] = trim($db->DBTimeStamp($expires),"'");
        }
        $q .= " WHERE id = ?";
        $parms[] = $uid;
        $dbresult = $db->Execute( $q, $parms );
        if( $dbresult == false ) return array( FALSE, $db->ErrorMsg() );

        if( $password ) {
            $res = $this->SetUserPassword($uid, $password);
            if( !$res[0] ) return $res;
        }

        // Changed to pass $uid back so it matches AddUser()
        return [ TRUE, $uid ];
    }

    /**
     * Set the user group memberships
     * does not alter any user properties.
     * does not validate group ids, but does validate uid
     *
     * @param int userid
     * @param array array of integer group ids
     * @return array (status,msg)
     */
    public function SetUserGroups(int $uid,array $grpids = null) : array
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $db = $this->GetDb();

        // first make sure this user exists
        $ret = $this->get_user($uid);
        if( !$ret ) return [FALSE,'User does not exist'];

        // then remove all his current assignments
        $q = "DELETE FROM ".CMS_DB_PREFIX."module_feusers_belongs WHERE userid = ?";
        $db->Execute( $q, array( $uid ));

        if( is_array($grpids) && count($grpids) ) {
            // and add all of them in
            $q = "INSERT INTO ".CMS_DB_PREFIX."module_feusers_belongs VALUES (?,?)";
            foreach( $grpids as $grpid ) {
                $dbresult = $db->Execute( $q, array( $uid, $grpid ) );
            }
        }
        return array( TRUE, "" );
    }

    /**
     * @deprecated
     * @see AssignUserToGroup()
     */
    public function AddUserToGroup( $uid, $gid )
    {
        return $this->AssignUserToGroup($uid,$gid);
    }

    // userid api method
    // returns true/false
    public function SetUserProperties(int $uid,array $props = null) : bool
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);

        if( is_array($props) && count($props) ) {
            if( cge_array::is_hash($props) ) {
                foreach( $props as $key => $val ) {
                    if ( ($r = $this->SetUserPropertyFull( $key, (string) $val, $uid )) == false) return FALSE;
                }
            }
            else {
                // todo: remove me.
                foreach( $props as $prop ) {
                    list( $key, $val ) = explode('=',$prop,2);
                    if ( ($r = $this->SetUserPropertyFull( $key, (string) $val, $uid )) == false) return FALSE;
                }
            }
        }

        return TRuE;
    }

    // userid api method
    // returns true/false
    public function UserExistsByID(int $uid) : bool
    {
        if( $uid < 1 ) throw new \LogicException('Invalid uid passed to '.__METHOD__);
        $data = $this->get_user($uid);
        return is_object($data);
    }

    // userid api method
    // returns an array or false
    public function GetUserProperties(int $uid)
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $ret = $this->get_user($uid, TRUE);
        if( !$ret ) return;
        return $ret->props;
    }

    // userid api method
    // returns an array of records or false
    // todo: add to UserManipulator
    // deprecated
    public function GetMemberGroupsArray(int $uid)
    {
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $uinfo = $this->get_user($uid);
        if( !$uinfo ) return;
        $list = $uinfo->groups;
        if( empty($list) ) return;

        // backwards compat, output an array of records
        $out = null;
        foreach( $list as $gid ) {
            $out[] = ['userid'=>$uid, 'groupid'=>(int) $gid];
        }
        return $out;
    }

    // userid api method
    public function GetUserProperty(string $title,$defaultvalue=false)
    {
        $title = trim($title);
        if( !$title ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $userid=$this->LoggedInId();
        if( $userid < 1 ) return false;
        return $this->GetUserPropertyFull($title,$userid,$defaultvalue);
    }

    // userid api method
    public function GetUserPropertyFull(string $title,int $uid, $defaultvalue=null)
    {
        $title = trim($title);
        if( !$title ) throw new \InvalidArgumentException('Invalid property name passed to '.__METHOD__);
        if( $uid < 1 ) throw new \InvalidArgumentException('Invalid userid passed to '.__METHOD__);

        $uinfo = $this->get_user($uid);
        if( !$uinfo ) return;

        $props = $uinfo->props;
        if( empty($props) ) return;
        if( isset($props[$title]) && !empty($props[$title]) ) return $props[$title];
        return $defaultvalue;
    }

    // userid api method
    // todo: add to UserManipulator
    public function IsUserPropertyValueUnique(int $uid = null, string $title, string $data) : bool
    {
        $db = $this->GetDb();
        $dbr = '';
        if( $uid > 0 ) {
            $q = 'SELECT id FROM '.CMS_DB_PREFIX.'module_feusers_properties
            WHERE title = ? AND userid != ? AND data = ?';
            $dbr = $db->GetOne($q,array($title,$uid,$data));
        }
        else {
            $q = 'SELECT id FROM '.CMS_DB_PREFIX.'module_feusers_properties
            WHERE title = ? AND data = ?';
            $dbr = $db->GetOne($q,array($title,$data));
        }
        if( $dbr ) return FALSE;
        return TRUE;
    }

    // userid api method
    public function SetUserProperty(string $title,string $data) : bool
    {
        $title = trim($title);
        if( !$title ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $userid=$this->LoggedInId();
        if( $userid < 1 ) return false;
        return $this->SetUserPropertyFull($title,$data,$userid);
    }

    // userid api method
    public function SetUserPropertyFull(string $title,string $data,int $userid) : bool
    {
        $title = trim($title);
        if( !$title || $userid < 1) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $defn = $this->GetPropertyDefn($title);
        if( !$defn ) return FALSE;
        if( $defn['force_unique'] && !$this->IsUserPropertyValueUnique($userid,$title,$data) ) return FALSE;

        $db = $this->GetDB();
        $q = "SELECT * FROM ".CMS_DB_PREFIX."module_feusers_properties WHERE title=? AND userid=?";
        $r = $db->Execute($q, [$title, $userid]);
        if (!$r || ($r->NumRows()==0)) {
            $q="INSERT INTO ".CMS_DB_PREFIX."module_feusers_properties (userid,title,data) VALUES (?,?,?)";
            $r=$db->Execute($q, [$userid, $title, $data]);
        } else {
            $row=$r->FetchRow();
            $q="UPDATE ".CMS_DB_PREFIX."module_feusers_properties SET data=? WHERE id=?";
            $r=$db->Execute($q, [$data, (int)$row['id']]);
        }

        return ($r!=false);
    }

    // userid api method
    public function DeleteUserPropertyFull(string $title,int $userid,bool $all=false) : bool
    {
        $title = trim($title);
        if( (!$title && !$all) || $userid < 1 ) throw new \InvalidArgumentException('Invalid data passed to '.__METHOD__);
        $db = $this->GetDB();
        $q = "DELETE FROM ".CMS_DB_PREFIX."module_feusers_properties WHERE userid=?";
        if (!$all) $q .=" AND title=?";
        $p=array();
        if ($all) $p=array($userid); else $p=array($userid,$title);
        $result=$db->Execute($q,$p);

        return ($result!=false);
    }

    // internal
    protected function DeleteAllUserPropertiesFull(int $userid) : bool
    {
        if( $userid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        return $this->DeleteUserPropertyFull("",$userid,true);
    }

    protected function use_usersalt()
    {
        $mod = $this->GetModule();
        return (int) $mod->GetPreference('use_usersalt',2);
    }

    // todo: add to UserManipulator
    public function CheckPassword(string $username,string $password,string $groups = null) : int
    {
        $username = trim($username);
        $password = trim($password);
        if( !$username || !$password ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $result = null;
        $db = $this->GetDb();

        $tmp = $this->GetUserInfoByName($username);
        if( !is_array($tmp) || !isset($tmp[0]) || !$tmp[0] || !$tmp[1] ) return 0;
        $uinfo = $tmp[1];
        if( $uinfo->id < 0 || !$uinfo->password ) return 0;

        if( $groups ) {
            $member_guids = $uinfo->groups;

            $groups = explode(',',$groups);
            // convert these group names to gids.
            $gids = [];
            $allgroups = $this->GetGroupList();
            if( !$allgroups ) return 0; // no groups defined
            $allgroups = array_flip($allgroups);
            foreach( $groups as $one ) {
                $one = trim($one);
                if( !$one ) continue;
                $gid = array_search($one, $allgroups);
                if( $gid === FALSE ) continue; // group does not exist
                $gids[] = $gid;
            }
            unset($allgroups,$groups);
            $gids = array_unique($gids);
            if( empty($gids) ) return 0; // no groups specified actually exist.

            $tmp = array_intersect($gids, $member_guids);
            if( empty($tmp) ) return 0;
        }

        // now verify the hash
        if( strlen($uinfo->password) == 32 ) {
            // this is the old, not really good hashing.
            // kept for backwards compatibility.
            if( !empty($uinfo->salt) ){
                $tmpb = md5(trim($password).$uinfo->salt);
                audit($uinfo->id,'FrontEndUsers','User has a salt, but an md5 encoded password');
                if( $uinfo->password == $tmpb ) return $uinfo->id;
            }
            $tmpa = md5(trim($password).$this->get_bad_salt());
            if( $uinfo->password === $tmpa ) return $uinfo->id;
        }
        else if( $uinfo->salt ) {
            // user has a salt... so it is using old sha1 hashing
            $tmp = sha1($password.$uinfo->salt);
            if( $uinfo->password === $tmp ) return $uinfo->id;
        }

        // usersalt == 2, new password hashes.
        return password_verify($password, $uinfo->password) ? $uinfo->id : 0;
    }

    // userid api method
    public function LoggedInName()
    {
        $userid=$this->LoggedInId();
        if ($userid > 0) return $this->GetUserName($userid); else return "";
    }

    /**
     * Determine if the user id is a member of the group(s) specified.
     *
     * @param integer userid
     * @param mixed integer (positive) group id, or an array of positive integer group ids.
     * @return boolean
     */
    public function MemberOfGroup(int $userid,int $groupid) : bool
    {
        if( $userid < 1 ) throw new \InvalidArgument('Invalid userid passed to '.__METHOD__);
        if( $groupid < 1 ) throw new \InvalidArgument('Invalid groupid passed to '.__METHOD__);

        $uinfo = $this->get_user($userid);
        if( !$uinfo ) return FALSE;
        if( !$uinfo->groups ) return FALSE;
        return in_array($groupid, $uinfo->groups);
    }

    // userid api method
    public function GetUserName(int $uid)
    {
        if( $uid < 1) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD_);
        $res = $this->get_user($uid);
        return ($res) ? $res->username : null;
    }

    public function GetUserNameFieldType() : int
    {
        return $this->GetSettings()->username_is_email ? 2 : 0;
    }

    // userid api method
    public function GetUserID(string $username)
    {
        $username = trim($username);
        if( !$username ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $db = $this->GetDb();
        $q = "SELECT id FROM ".CMS_DB_PREFIX."module_feusers_users WHERE username = ?";
        $uid = (int) $db->GetOne($q,[$username]);
        if( $uid < 1 ) return;
        return $uid;
    }

    // userid api method
    // returns array
    public function AddGroup(string $name, string $description = null) : array
    {
        $name = trim($name);
        if( !$name ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $db = $this->GetDb();

        // see if it exists already or not (by name)
        $q = "SELECT * FROM ".CMS_DB_PREFIX."module_feusers_groups WHERE groupname = ?";
        $dbresult = $db->Execute( $q, array( $name ) );
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());
        $row = $dbresult->FetchRow();
        if( $row ) {
            $module = $this->GetModule();
            return array(FALSE,$module->Lang('error_groupname_exists'));
        }

        $q = "INSERT INTO ".CMS_DB_PREFIX."module_feusers_groups (groupname,groupdesc) VALUES (?,?)";
        $dbresult = $db->Execute( $q, array( $name, $description ) );
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());
        $grpid = $db->Insert_ID();
        return array(TRUE,$grpid);
    }

    // userid api method
    // returns array
    public function AddUser(string $name, string $password, int $expires, bool $nonstd = FALSE, int $createdate = null) : array
    {
        $name = trim($name);
        $password = trim($password);
        if( !$name || !$password ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $db = $this->GetDb();

        // see if it exists already or not (by name)
        $uid = $this->GetUserID($name);
        if( $uid ) {
            $module = $this->GetModule();
            return array(FALSE,$module->Lang('error_username_exists'));
        }

        // generate the salt.
        $salt = null;
        if( $this->use_usersalt() == 1 )  $salt = sha1(time().$name.rand().$expires.__FILE__);

        // insert the record
        $createdate = (int) $createdate;
        if( $createdate < 1 ) $createdate = time();
        $q = "INSERT INTO ".CMS_DB_PREFIX."module_feusers_users (username,password,createdate,expires,nonstd,salt) VALUES (?,?,?,?,?,?)";
        $dbresult = $db->Execute( $q, array( $name, ' ',
                                             trim($db->DbTimeStamp($createdate),"'"),
                                             trim($db->DbTimeStamp($expires),"'"),
                                             (bool) $nonstd, $salt ) );
        if( !$dbresult ) return array(FALSE,$db->ErrorMsg());
        $uid = $db->Insert_ID();

        // set the password
        $res = $this->SetUserPassword($uid,$password);
        if( !$res[0] ) return $res;

        return array(TRUE,$uid);
    }

    // userid api method
    public function GetGroupName(int $gid)
    {
        if( $gid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $info = $this->GetGroupInfo($gid);
        if( $info ) return $info['groupname'];
    }

    // userid api method
    public function GetGroupDesc(int $gid)
    {
        if( $gid < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $info = $this->GetGroupInfo($gid);
        if( $info ) return $info['groupdesc'];
    }

    // userid api method
    // returns an array
    public function DeleteGroupFull(int $id) : array
    {
        if( $id < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $db = $this->GetDb();
        try {
            $db->BeginTrans();

            // delete all property relations from this group
            $q = "DELETE FROM ".CMS_DB_PREFIX."module_feusers_grouppropmap WHERE group_id = ?";
            $db->Execute( $q, array( $id ) );

            // delete all indication that anybody is a member
            // of this group
            $q = "DELETE FROM ".CMS_DB_PREFIX."module_feusers_belongs WHERE groupid = ?";
            $db->Execute( $q, array( $id ) );

            // and then delete the group
            $q = "DELETE FROM ".CMS_DB_PREFIX."module_feusers_groups WHERE id = ?";
            $db->Execute( $q, array( $id ) );

            $db->CommitTrans();
            return array( TRUE, '' );
        }
        catch( \Exception $e ) {
            $db->RollbackTrans();
            $mod = $this->GetModule();
            audit($id,$mod->GetName(),'Problem Deleting Group: '.$e->GetMessage());
            cge_utils::log_exception($e);
            return array(FALSE,$e->GetMessage());
        }
    }

    // userid api method
    public function GetGroupList() : array
    {
        $list = $this->GetGroupListFull();
        $result = [];
        if( !empty($list) ) {
            foreach( $list as $gid => $info ) {
                $result[$info['groupname']] = (int) $gid;
            }
        }
        return $result;
    }

    // userid api method
    public function GetGroupListFull() : array
    {
        $db = $this->GetDb();
        $query = 'SELECT g.*,count(b.userid) AS count FROM '.CMS_DB_PREFIX.'module_feusers_groups g
                  LEFT JOIN '.CMS_DB_PREFIX.'module_feusers_belongs b
                  ON g.id = b.groupid GROUP BY g.id';
        $dbr = $db->GetArray($query);
        if( is_array($dbr) ) return cge_array::to_hash($dbr,'id');
        return [];
    }

    // old userid api method
    public function GetGroupID(string $groupname)
    {
        $groupname = trim($groupname);
        if( !$groupname ) throw new \InvalidArgumentException('Invalid groupname passed to '.__METHOD__);
        $list = $this->GetGroupListFull();
        if( is_array($list) ) {
            foreach( $list as $gid => $info ) {
                if( $info['groupname'] == $groupname ) return $gid;
            }
        }
    }

    // old userid api method
    public function DeleteUser(int $id) : bool
    {
        if( $id < 1 ) throw new \InvalidArgumentException('Invalid uid passed to '.__METHOD__);
        $res = $this->DeleteUserFull($id);
        if( $res[0] ) return true;
        return false;
    }

    /**
     * @ignore
     */
    public function GetDefaultGroups()
    {
        $dflt_group = $this->GetSettings()->default_group;
        if( $dflt_group < 1 ) {
            $list = $this->GetGroupListFull();
            if( $list ) {
                $keys = array_keys($list);
                $dflt_group = (int) $keys[0];
            }
        }
        if( $dflt_group ) return [ $dflt_group ];
    }

} // class
