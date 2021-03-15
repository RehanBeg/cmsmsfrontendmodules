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
use FrontEndUsers\userSet;

final class feu_utils
{
    private static $_mod;
    private static $_userfiles;

    private function __construct() {}

    public static function get_mod()
    {
        if( !self::$_mod ) self::$_mod = \cms_utils::get_module(MOD_FRONTENDUSERS);
        return self::$_mod;
    }

    public static function generate_random_printable_string()
    {
        $code = substr(strtoupper(md5(__FILE__.session_id().rand().microtime(TRUE))),0,25);
        return $code;
    }

    public static function checkUpload($key)
    {
        $mod = self::get_mod();
        if( !isset($_FILES[$key]) || !isset($_FILES) ) return [ false, $mod->Lang('error_missing_upload') ];
        $file = $_FILES[$key];
        if( !isset($file['name']) || !isset($file['size']) || $file['size'] == 0 ) return [ false,$mod->Lang('error_problem_upload') ];

        if (!isset ($file['type'])) $file['type'] = '';
        if (!isset ($file['size'])) $file['size'] = '';
        if (!isset ($file['tmp_name'])) return [ false, $mod->Lang('error_problem_upload') ];
        $file['name'] =
            preg_replace('/[^a-zA-Z0-9\.\$\%\'\`\-\@\{\}\~\!\#\(\)\&\_\^]/', '',
            str_replace (array (' ', '%20'), array ('_', '_'), $file['name']));

        // check the filename
        if( !$mod->is_allowed_upload($file['name']) ) return [ false, $mod->Lang('error_invalidfileextension') ];
        return [ TRUE ];
    }

    public static function create_query_from_array( array $filter, int $offset ) : feu_user_query
    {
        $limit = $filter['limit'];
        $groupid = $filter['group'];
        $userregex = $filter['regex'];
        $property = $filter['propsel'];
        $propregex = $filter['propval'];
        $loggedinonly = $filter['loggedinonly'];
        $sort = $filter['sortby'];
        $disabledstatus = isset( $filter['disabledstatus'] ) ? $filter['disabledstatus'] : null;

        $query = new feu_user_query();
        $query->set_result_type(feu_user_query::RESULT_TYPE_FULL);
        if( (int)$limit > 0 ) $query->set_pagelimit($limit);
        if( (int)$offset > 0 ) $query->set_offset($offset);
        if( $groupid > 0 ) $query->add_and_opt(feu_user_query_opt::MATCH_GROUPID,$groupid);
        if( $userregex ) $query->add_and_opt(feu_user_query_opt::MATCH_USERNAME_RE,$userregex);
        if( $property ) {
            $defn = self::get_mod()->GetPropertyDefn( $property );
            $obj = null;
            if( $defn['type'] == \FrontEndUsers::FIELDTYPE_CHECKBOX ) {
                if( trim($propregex) === '0' ) {
                    // need to test if the property is NOT set
                    $obj = new feu_user_query_opt( feu_user_query_opt::MATCH_NOTHASPROPERTY, $property );
                }
            }
            if( !$obj && $propregex ) $obj = new feu_user_query_opt(feu_user_query_opt::MATCH_PROPERTY_RE,$property,$propregex);
            if( $obj ) $query->add_and_opt_obj($obj);
        }
        if( $loggedinonly ) $query->add_and_opt(feu_user_query_opt::MATCH_LOGGEDIN,1);
        switch( $disabledstatus ) {
        case 'en':
            $query->add_and_opt( feu_user_query_opt::MATCH_NOTDISABLED );
            break;
        case 'dis':
            $query->add_and_opt( feu_user_query_opt::MATCH_DISABLED );
            break;
        }

        switch( $sort ) {
        case 'username':
        case 'username asc':
            $query->set_sortby(feu_user_query::RESULT_SORTBY_USERNAME);
            $query->set_sortorder(feu_user_query::RESULT_SORTORDER_ASC);
            break;
        case 'username desc':
            $query->set_sortby(feu_user_query::RESULT_SORTBY_USERNAME);
            $query->set_sortorder(feu_user_query::RESULT_SORTORDER_DESC);
            break;
        case 'createdate':
        case 'createdate asc':
            $query->set_sortby(feu_user_query::RESULT_SORTBY_CREATED);
            $query->set_sortorder(feu_user_query::RESULT_SORTORDER_ASC);
            break;
        case 'createdate desc':
            $query->set_sortby(feu_user_query::RESULT_SORTBY_CREATED);
            $query->set_sortorder(feu_user_query::RESULT_SORTORDER_DESC);
            break;
        case 'expires':
        case 'expires asc':
            $query->set_sortby(feu_user_query::RESULT_SORTBY_EXPIRES);
            $query->set_sortorder(feu_user_query::RESULT_SORTORDER_ASC);
            break;
        case 'expires desc':
            $query->set_sortby(feu_user_query::RESULT_SORTBY_EXPIRES);
            $query->set_sortorder(feu_user_query::RESULT_SORTORDER_DESC);
            break;
        }
        return $query;
    }

    public static function get_users_from_filter( array $filter, int $offset, &$total_matches ) : userSet
    {
        // todo: remove me.
        $query = self::create_query_from_array($filter, $offset);
        return self::get_mod()->get_query_results( $query );
    }

    public static function resolve_preftpl_to_page($prefname,$uid,$dflt = null)
    {
        $prefname = trim($prefname);
        $uid = (int) $uid;
        if( !$prefname || $uid < 1 ) return $dflt;

        // should throw an exception maybe.
        $feu = self::get_mod();
        $res = $feu->GetUserInfo( $uid );
        if( !is_array($res) || $res[0] == FALSE ) return $dflt;
        $uinfo = $res[1];

        $tpldata = $feu->GetPreference($prefname);
        if( !$tpldata ) return $dflt;

        $smarty = cmsms()->GetSmarty();
        $tmp_tpl = $smarty->CreateTemplate('string:'.$tpldata);
        $tmp_tpl->assign('username',$uinfo['username']);
        $tmp_tpl->assign('uid',$uid);
        $groups = $feu->GetMemberGroupsArray($uid);
        $groupname = null;
        if( count($groups) ) $groupname = $feu->GetGroupName( $groups[0]['groupid'] );
        $tmp_tpl->assign('groupname',$groupname);
        $page = $tmp_tpl->fetch();
        $dest = $feu->resolve_alias_or_id($page);
        if( $dest ) return $dest;
        return $dflt;
    }

    public static function save_temp_logindata( $username, $password, $onlygroups )
    {
        $obj = new \StdClass;
        $obj->username = $username;
        $obj->password = $password; // plain text
        $obj->onlygroups = $onlygroups;
        $key = md5(__CLASS__.__FILE__);
        $data = \cge_encrypt::encrypt( $key, serialize( $obj ) );
        $feu = self::get_mod();
        $feu->session_put( $key, $data );
    }

    public static function retrieve_temp_logindata()
    {
        $key = md5(__CLASS__.__FILE__);
        $feu = self::get_mod();
        $data = $feu->session_get( $key );
        if( !$data ) return;
        $feu->session_clear( $key );
        $data = unserialize( \cge_encrypt::decrypt( $key, $data ) );
        return $data;
    }

} // class

#
# EOF
#
