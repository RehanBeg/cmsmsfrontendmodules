<?php
declare(strict_types=1);
namespace FrontEndUsers;
use feu_user_query;
use feu_user_query_opt;
use CMSMS\Database\Connection as Database;
use cge_utils;

class FeuUserQueryDecorator extends UserManipulatorInterface
{
    protected function wildcard(string $term) : string
    {
        $term = str_replace('%','\%',$term);
        $term = str_replace('_','\_',$term);
        $term = str_replace('*','%',$term);
        return $term;
    }

    public function create_new_query() : feu_user_query
    {
        return new feu_user_query();
    }

    protected function preload_properties_for_users(array $uids)
    {
        $sql = 'SELECT userid, title, data FROM '.CMS_DB_PREFIX.'module_feusers_properties WHERE userid IN (%s) ORDER BY userid, title';
        $sql = sprintf($sql,implode(',',$uids));

        $rs = $this->GetDb()->GetArray($sql);
        $out = null;
        foreach( $rs as $row ) {
            $out[$row['userid']][$row['title']] = $row['data'];
        }
        return $out;
    }

    protected function preload_groups_for_users(array $uids)
    {
        $sql = 'SELECT userid, groupid FROM '.CMS_DB_PREFIX.'module_feusers_belongs WHERE userid IN (%s) ORDER BY userid';
        $sql = sprintf($sql,implode(',',$uids));

        $rs = $this->GetDb()->GetArray($sql);
        $out = null;
        foreach( $rs as $row ) {
            $out[$row['userid']][] = (int) $row['groupid'];
        }
        return $out;
    }

    protected function preload_tokens_for_users(array $uids)
    {
        $sql = 'SELECT * FROM '.$this->tokens_table_name().' WHERE uid IN (%s) ORDER BY uid';
        $sql = sprintf($sql,implode(',',$uids));

        $rs = $this->GetDb()->GetArray($sql);
        $out = null;
        foreach( $rs as $row ) {
            $out[$row['uid']][] = AuthToken::from_array($row);
        }
        return $out;
    }

    public function get_query_results( feu_user_query $query ) : userSet
    {
        $db = $this->GetDb();
        $where  = $qparms = $joins = [];
        $jcount = 0;
        $having = null;

        $qrec = 'SELECT SQL_CALC_FOUND_ROWS u.* FROM '.cms_db_prefix().'module_feusers_users u';

        foreach( $query->get_opts() as $opt ) {
            switch( $opt->get_type() ) {
            case feu_user_query_opt::MATCH_USERID:
                $where[] = 'u.id = ?';
                $qparms[] = (int) $opt->get_expr();
                break;

            case feu_user_query_opt::MATCH_USERNAME:
                $where[]  = 'u.username LIKE ?';
                $qparms[] = $this->wildcard($opt->get_expr());
                break;

            case feu_user_query_opt::MATCH_USERNAME_RE:
                $where[]  = 'u.username REGEXP '.$db->qstr($opt->get_expr());
                break;

            case feu_user_query_opt::MATCH_PASSWORD:
                $where[]  = 'u.password = ?';
                $qparms[] = $opt->get_expr();
                break;

            case feu_user_query_opt::MATCH_NOTEXPIRED:
                $tmp = $db->DbTimeStamp(time() - 30);
                $where[] = "u.expires > {$tmp}";
                break;

            case feu_user_query_opt::MATCH_NOTDISABLED:
                $where[] = "u.disabled = 0";
                break;

            case feu_user_query_opt::MATCH_DISABLED:
                $where[] = "u.disabled = 1";
                break;

            case feu_user_query_opt::MATCH_MUSTVALIDATE:
                $expr = (int) $opt->get_expr();
                if( empty($expr) ) {
                    $where[] = "u.must_validate = 1";
                } else {
                    $where[] = "u.must_validate = {$expr}";
                }
                break;

            case feu_user_query_opt::MATCH_EXPIRES_LT:
                $tmp = $db->DbTimeStamp($opt->get_expr());
                $where[] = "u.expires < {$tmp}";
                break;

            case feu_user_query_opt::MATCH_CREATED_GE:
                $tmp = $db->DbTimeStamp($opt->get_expr());
                $where[] = "u.createdate >= {$tmp}";
                break;

            case feu_user_query_opt::MATCH_CREATED_LT:
                $tmp = $db->DbTimeStamp($opt->get_expr());
                $where[] = "u.createdate < {$tmp}";
                break;

            case feu_user_query_opt::MATCH_GROUP:
                $gid = $this->GetGroupID($opt->get_expr());
                if( $gid < 1 ) throw new Exception('invalid match_group value');
                $joins[] = 'LEFT JOIN '.cms_db_prefix().'module_feusers_belongs bl ON u.id = bl.userid';
                $where[] = 'bl.groupid = ?';
                $qparms[] = $gid;
                break;

            case feu_user_query_opt::MATCH_LOGGEDIN:
                $having = 'count(li.userid) > 0';
                break;

            case feu_user_query_opt::MATCH_GROUPID:
                $expr = $opt->get_expr();
                if( is_array($expr) ) {
                    $tmp = array();
                    foreach( $expr as $one ) {
                        $one = (int)$one;
                        if( $one < 1 ) continue;
                        if( !in_array($one,$tmp) ) $tmp[] = $one;
                    }
                    if( count($tmp) == 0 ) throw new Exception('No valid group ids specified');
                    $joins[] = 'LEFT JOIN '.cms_db_prefix().'module_feusers_belongs bl ON u.id = bl.userid';
                    $where[] = 'bl.groupid IN ('.implode(',',$tmp).')';
                }
                else {
                    $joins[] = 'LEFT JOIN '.cms_db_prefix().'module_feusers_belongs bl ON u.id = bl.userid';
                    $where[] = 'bl.groupid = ?';
                    $qparms[] = $expr;
                }
                break;

            case feu_user_query_opt::MATCH_USERNAMELIST:
                $tmp = $opt->get_expr();
                if( !is_array($tmp) ) $tmp = explode(',',$tmp);
                $tmp2 = array();
                foreach( $tmp as $one ) {
                    $tmp2[] = "'".trim($one)."'";
                }
                $tmp2 = array_unique($tmp2);
                $where[] = 'u.username IN ('.implode(',',$tmp2).')';
                break;

            case feu_user_query_opt::MATCH_USERLIST:
                $tmp = $opt->get_expr();
                if( !is_array($tmp) ) $tmp = explode(',',$tmp);
                $tmp2 = array();
                foreach( $tmp as $one ) {
                    if( (int)$one < 1 ) continue;
                    $tmp2[] = (int)$one;
                }
                $tmp2 = array_unique($tmp2);
                $where[] = 'u.id IN ('.implode(',',$tmp2).')';
                break;

            case feu_user_query_opt::MATCH_PROPERTY:
                $feu = cge_utils::get_module(MOD_FRONTENDUSERS);
                $defns = $feu->GetPropertyDefns();
                if( !in_array($opt->get_expr(),array_keys($defns)) ) throw new Exception('invalid value');
                $jcount++;
                $joins[] = 'LEFT JOIN '.cms_db_prefix()."module_feusers_properties pr{$jcount}
                    ON pr{$jcount}.userid = u.id";
                $where[] = "pr{$jcount}.title = '".$opt->get_expr()."'";
                if( $opt->get_opt() ) {
                    if( strstr($opt->get_opt(),'*') === FALSE ) {
                        $where[] = "pr{$jcount}.data = '".$opt->get_opt()."'";
                    }
                    else {
                        $where[] = "pr{$jcount}.data LIKE '".$this->wildcard($opt->get_opt())."'";
                    }
                }
                break;

            case feu_user_query_opt::MATCH_NOTHASPROPERTY:
                // test if the user DOES NOT have a specific property
                $where[] = "u.id NOT IN (SELECT userid FROM ".cms_db_prefix()."module_feusers_properties WHERE title = '{$opt->get_expr()}')";
                break;

            case feu_user_query_opt::MATCH_PROPERTY_RE:
                $feu = cge_utils::get_module('FrontEndUsers');
                $defns = $feu->GetPropertyDefns();
                if( !in_array($opt->get_expr(),array_keys($defns)) ) {
                    throw new Exception('invalid value');
                }
                $jcount++;
                $joins[] = 'LEFT JOIN '.cms_db_prefix()."module_feusers_properties pr{$jcount}
                      ON pr{$jcount}.userid = u.id
                     AND pr{$jcount}.title = '".$opt->get_expr()."'";
                $where[] = "pr{$jcount}.data REGEXP ".$db->qstr($opt->get_opt());
                break;
            }
        }

        // assembly
        if( count($joins) ) $qrec .= ' '.implode(' ',$joins);
        if( count($where) ) $qrec .= "\nWHERE ".implode(' AND ',$where);

        $orderby = 'username';
        switch( $query->get_sortby() ) {
        case feu_user_query::RESULT_SORTBY_USERNAME:
            $orderby = 'username';
            break;
        case feu_user_query::RESULT_SORTBY_CREATED:
            $orderby = 'createdate';
            break;
        case feu_user_query::RESULT_SORTBY_EXPIRES:
            $orderby = 'expires';
            break;
        }

        switch( $query->get_sortorder() ) {
        case feu_user_query::RESULT_SORTORDER_ASC:
            $orderby .= ' ASC';
            break;
        case feu_user_query::RESULT_SORTORDER_DESC:
            $orderby .= ' DESC';
            break;
        }

        $qrec .= ' GROUP BY u.id';
        if( $having ) $qrec .= ' HAVING '.$having;
        $qrec .= ' ORDER BY '.$orderby;
        $matches = null;
        $found_rows = 0;
        try {
            $rs = $db->SelectLimit($qrec,$query->get_pagelimit(),$query->get_offset(),$qparms);
            $found_rows = (int) $db->GetOne('SELECT FOUND_ROWS()');

            // extract the list of uids.
            $uids = array();
            while( !$rs->EOF ) {
                $uids[] = $rs->fields['id'];
                $rs->MoveNext();
            }
            $rs->MoveFirst();

            $matches = null;
            if( count($uids) ) {
                // preload property info for these users
                $property_info = $this->preload_properties_for_users($uids);
                $group_info = $this->preload_groups_for_users($uids);
                $tokens = $this->preload_tokens_for_users($uids);

                // put everything together, and create users
                while( !$rs->EOF ) {
                    $row = $rs->fields;
                    $uid = $row['id'];
                    if( isset($property_info[$uid]) ) $row['props'] = $property_info[$uid];
                    if( isset($group_info[$uid]) ) $row['groups'] = $group_info[$uid];
                    if( isset($tokens[$uid]) ) $row['tokens'] = $tokens[$uid];
                    $matches[] = $this->create_user($row);
                    $rs->MoveNext();
                }
            }
        }
        catch( \cg_sql_error $e ) {
            cge_utils::log_exception($e);
        }
        return new userSet($query, $found_rows, $matches);
    }

    public function userset_to_list( userSet $set ) : array
    {
        // given a user set... convert it to a list that can be used in a dropdown
        $out = [];
        foreach( $set as $one_user ) {
            $out[$one_user->id] = $one_user->username;
        }
        return $out;
    }
} // class
