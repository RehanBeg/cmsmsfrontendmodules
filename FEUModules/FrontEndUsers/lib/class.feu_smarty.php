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

final class feu_smarty
{
    private static $_module;
    private static $_properties;
    private function __construct() {}

    private static function _get_module()
    {
        if( !self::$_module ) self::$_module = cms_utils::get_module(MOD_FRONTENDUSERS);
        return self::$_module;
    }

    public static function get_current_userid()
    {
        $uid = self::_get_module()->LoggedInId();
        return $uid;
    }

    public static function get_current_username()
    {
        return self::_get_module()->LoggedInName();
    }

    public static function get_userid(string $username)
    {
        $username = trim($username);
        if( $username ) return (int)self::_get_module()->GetUserID($username);
    }

    public static function get_username(int $uid = null)
    {
        $mod = self::_get_module();
        $uid = (int) $uid;
        if( $uid < 1 ) $uid = $mod->LoggedInId();
        if( $uid < 1 ) return;
        return $mod->GetUserName($uid);
    }

    public static function get_email(int $uid = null)
    {
        $mod = self::_get_module();
        $uid = (int) $uid;
        if( $uid < 1 ) $uid = $mod->LoggedInId();
        if( $uid < 1 ) return;
        $tmp = $mod->GetEmail($uid);
        return $tmp;
    }

    public static function get_userinfo(int $uid = null)
    {
        $uinfo = null;
        $uid = (int) $uid;
        if( $uid < 1 ) $uid = self::_get_module()->LoggedInId();
        if( $uid < 1 ) return;
        $uid = (int)$uid;
        if( $uid > 0 ) {
            if( is_object(self::_get_module()) ) {
                $uinfo = self::_get_module()->get_user($uid);
            }
        }
        return $uinfo;
    }

    public static function get_users_by_groupname(string $groupname,$for_list = FALSE)
    {
        $groupname = trim($groupname);
        $for_list = (bool) $for_list;
        if( empty($groupname) ) return;

        if( is_object(self::_get_module()) ) {

            $gid = self::_get_module()->GetGroupID($groupname);
            if( $gid ) {
                $query = new feu_user_query();
                $query->add_and_opt( feu_user_query_opt::MATCH_GROUPID, $gid );
                $rs = $query->execute();

                $users = [];
                while( !$rs->EOF ) {
                    $oneuser = $rs->fields;
                    if( $for_list ) {
                        $users[$oneuser['id']] = $oneuser['username'];
                    }
                    else {
                        $users[] = array('id'=>$oneuser['id'],'username'=>$oneuser['username']);
                    }
                    $rs->MoveNext();
                }
                return $users;
            }
        }
    }

    public static function get_group_memberlist(int $gid)
    {
        if( $gid < 1 ) throw new \InvalidArgumentException('Invalid gid passed to '.__METHOD__);
        $query = new feu_user_query();
        $query->add_and_opt( feu_user_query_opt::MATCH_GROUPID, $gid );
        $rs = $query->execute();

        $users = [];
        while( !$rs->EOF ) {
            $oneuser = $rs->fields;
            $users[$oneuser['id']] = $oneuser['username'];
            $rs->MoveNext();
        }
        return $users;
    }

    public static function get_user_expiry(int $uid = null)
    {
        if( $uid < 1 ) $uid = self::_get_module()->LoggedInId();
        if( $uid < 1 ) return;

        $res = null;
        $res = self::_get_module()->GetExpiryDate($uid);
        return $res;
    }

    public static function user_expired(int $uid = null)
    {
        if( $uid < 1 ) $uid = self::_get_module()->LoggedInId();
        if( $uid < 1 ) return;
        if( !is_object(self::_get_module()) ) return;

        $res = self::_get_module()->IsAccountExpired($uid);
        return $res;
    }

    public static function get_user_properties(int $uid = null)
    {
        try {
            $uid = (int) $uid;
            if( $uid < 1 ) $uid = self::_get_module()->LoggedInId();
            if( $uid < 1 ) return;

            $res = self::_get_module()->GetUserProperties($uid);
            if( !is_array($res) || empty($res) ) return;

            return $res;
        }
        catch( \Exception $e ) {
	    // nothing here
        }
    }

    public static function get_user_property(string $property,int $uid = null)
    {
        try {
            $property = trim($property);
            if( !$property ) throw new \InvalidArgumentException('0');
            $uid = (int) $uid;
            if( $uid < 1 ) $uid = self::_get_module()->LoggedInId();
            if( $uid < 1 ) return;

            $tmp = self::get_user_properties($uid);
            if( isset($tmp[$property]) ) return $tmp[$property];
        }
        catch( \Exception $e ) {
            // nothing here
        }
    }

    public static function get_dropdown_text(string $propname,string $propvalue)
    {
        $res = null;
        $propname = trim($propname);
        $propvalue = trim($propvalue);
        if( !$propname ) throw new \InvalidArgumentException('Invalid propname passed to '.__METHOD__);

        try {
            $module = self::_get_module();
            if( !$module ) throw new \LogicException('Cannot get FEU module'); // should never happen
            $props = $module->GetPropertyDefns();
            foreach( $props as $one ) {
                if( $one['type'] == 4 || $one['type'] == 5 ) {
                    $tmp2 = $module->GetSelectOptions($one['name']);
                    $one['options'] = [];
                    foreach( $tmp2 as $k => $v ) {
                        $one['options'][$v] = $k;
                    }
                }
                $props[$one['name']] = $one;
            }
            if( !isset($props[$propname]) ) throw new \InvalidArgumentException("Property $propname is not known");
            if( (self::$_properties[$propname]['type'] != 4 && self::$_properties[$propname]['type'] != 5) ||
                !isset(self::$_properties[$propname]['options']) ) throw new \InvalidArgumentException("Property $propname does not have options, but it should");
            if( !isset(self::$_properties[$propname]['options'][$propvalue]) ) throw new \InvalidArgumentException("Property $propname has no option with value $propvalue");

            $res = self::$_properties[$propname]['options'][$propvalue];
        }
        catch( Exception $e ) {
            // nothing here
        }
        return $res;
    }

    public static function get_multiselect_text(string $propname,string $propvalue)
    {
        $values = explode(',',$propvalue);
        $res = [];
        foreach( $values as $one ) {
            $res[] = self::get_dropdown_text($propname,$one);
        }
        return $res;
    }

    public static function get_group_list()
    {
        $list = array_flip(self::_get_module()->GetGroupList());
        return $list;
    }

    public static function get_user_groups(int $uid = null)
    {
        if( $uid < 1 ) $uid = self::_get_module()->LoggedInId();
        if( $uid < 1 ) return;

        $groups = self::_get_module()->GetMemberGroupsArray( $uid );
        $gns = array();
        $gids = array();
        if( $groups !== false ) {
            foreach( $groups as $gid ) {
                $gids[] = $gid['groupid'];
                $gns[$gid['groupid']] = self::_get_module()->GetGroupName($gid['groupid']);
            }
        }
        return $gns;
    }

    public static function is_user_memberof($groups,int $uid=null)
    {
        if( $uid < 1 ) $uid = self::_get_module()->LoggedInId();
        if( $uid < 1 ) return;

        if( !is_array($groups) ) $groups = explode(',',trim($groups));
        $tmp = array();
        foreach( $groups as $grp ) {
            $grp = trim($grp);
            if( !$grp ) continue;
            $tmp[] = $grp;
        }
        if( !count($tmp) ) return;

        $groups = self::get_user_groups($uid);
        foreach( $tmp as $one ) {
            if( in_array($one,$groups) ) return TRUE;
        }
    }

    public static function is_user_valid(int $uid=null)
    {
        if( $uid < 1 ) $uid = self::_get_module()->LoggedInId();
        if( $uid < 1 ) return;

        $user = self::_get_module()->get_user($uid);
        if( !$user ) return;

        $valid = $user->disabled || $user->expired;
        return !$valid;
    }
} // class

#
# EOF
#
