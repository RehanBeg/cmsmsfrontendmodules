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

/**
 * This file provides advanced query mechanisms for FEU users
 *
 * @package FrontEndUsers
 * @category Query/Filter
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2019 by Robert Campbell
 */

declare(strict_types=1);
use FrontEndUsers\Filter;
use FrontEndUsers\userSet;

/**
 * This class describes a single option to an feu_user_query
 *
 * @package FrontEndUsers
 */
class feu_user_query_opt
{
    /**
     * This option matches a single userid
     */
    const MATCH_USERID      = '*userid*';

    /**
     * This option matches a single username
     */
    const MATCH_USERNAME    = '*username*';

    /**
     * This option matches a username regular expression
     */
    const MATCH_USERNAME_RE = '*username-re*';

    /**
     * This option matches a single password.
     * The password string must be encrypted.
     */
    const MATCH_PASSWORD    = '*password*';

    /**
     * This option allows matching users whos expiry date is less than a specified timestamp.
     */
    const MATCH_EXPIRES_LT  = '*expires-lt*';

    /**
     * This option allows matching uers who have not yet expired
     */
    const MATCH_NOTEXPIRED  = '*notexpired*';

    /**
     * This option allows matching users who are not disabled.
     */
    const MATCH_NOTDISABLED = '*notdisabled*';

    /**
     * This option allows matching users who are disabled.
     */
    const MATCH_DISABLED    = '*disabled*';

    /**
     * This option allows matching users who must validate their account.
     */
    const MATCH_MUSTVALIDATE = '*must_validate*';

    /**
     * This option allos matching users who are members of a specific named group.
     */
    const MATCH_GROUP       = '*group*';

    /**
     * This option allows matching users who are members of a specific group (by id)
     */
    const MATCH_GROUPID     = '*gid*';

    /**
     * This action allows matching users who have a specific property and value.
     */
    const MATCH_PROPERTY    = '*property*';

    /**
     * This action allows matching users who have a specific property the value of which matches a regular expression.
     */
    const MATCH_PROPERTY_RE = '*property-re*';

    /**
     * This action allows matching users by a specified list of uids.
     */
    const MATCH_USERLIST    = '*userlist*';

    /**
     * this action allows matching users by a specified list of usernames.
     */
    const MATCH_USERNAMELIST = '*usernamelist*';

    /**
     * this action allows amtching users that have non expired authorization tokens.
     */
    const MATCH_LOGGEDIN    = '*loggedin*';

    /**
     * This action allows matching users that were created after a specified timestamp.
     */
    const MATCH_CREATED_GE  = '*created_ge*';

    /**
     * This action allows matching users that were created before a specified timestamp.
     */
    const MATCH_CREATED_LT  = '*created_lt*';

    /**
     * This action allows matching users that do not have a value for the specified property
     */
    const MATCH_NOTHASPROPERTY = '*nothasproperty*';

    /**
     * @ignore
     */
    private $_type;

    /**
     * @ignore
     */
    private $_expr;

    /**
     * @ignore
     */
    private $_opt;

    /**
     * Constructor.
     * this is used to create a new option to provide to an feu_user_query object.
     *
     * @param string $type The match type constant.
     * @param mixed $expr An optional expression or data to the match type.  Different match types may require one or two arguments.
     * @param mixed $opt More optional data to the match type.  Different match types may require one or two arguments.
     */
    public function __construct(string $type,$expr = null,$opt = null)
    {
        switch($type) {
        case self::MATCH_USERID:
        case self::MATCH_USERNAME:
        case self::MATCH_USERNAME_RE:
        case self::MATCH_PASSWORD:
        case self::MATCH_EXPIRES_LT:
        case self::MATCH_CREATED_GE:
        case self::MATCH_CREATED_LT:
        case self::MATCH_GROUP:
        case self::MATCH_GROUPID:
        case self::MATCH_USERLIST:
        case self::MATCH_USERNAMELIST:
        case self::MATCH_NOTHASPROPERTY:
            if( empty($expr) ) throw new Exception('invalid value for expr on expr '.$type);
            $this->_type = $type;
            $this->_expr = $expr;
            break;

        case self::MATCH_MUSTVALIDATE;
            // allows an optional expression (either 0 or 1)
            $this->_type = $type;
            if( !empty($expr) ) $this->_expr = (int) $expr;
            break;

        case self::MATCH_LOGGEDIN:
        case self::MATCH_NOTEXPIRED:
        case self::MATCH_NOTDISABLED:
        case self::MATCH_DISABLED:
            $this->_type = $type;
            break;

        case self::MATCH_PROPERTY_RE:
            if( empty($expr) ) throw new Exception('invalid value for expr on expr '.$type);
            if( empty($opt) ) throw new Exception('invalid opt value');
            $this->_type = $type;
            $this->_expr = $expr;
            $this->_opt = $opt;
            break;

        case self::MATCH_PROPERTY:
            if( empty($expr) ) throw new Exception('invalid value for expr on expr '.$type);
            $this->_type = $type;
            $this->_expr = $expr;
            $this->_opt = $opt;
            break;

        default:
            throw new Exception('invalid match option');
        }
    }

    /**
     * Returns the match type of an option.
     *
     * @return string
     */
    public function get_type()
    {
        return $this->_type;
    }

    /**
     * Returns any expression provided for the option.
     *
     * @return mixed
     */
    public function get_expr()
    {
        return $this->_expr;
    }

    /**
     * Returns any optional data provided for the option
     *
     * @return mixed
     */
    public function get_opt()
    {
        return $this->_opt;
    }
} // class


/**
 * A class to provide advanced querying and filtering of users in the FrontEndUsers databaase.
 *
 * This object is used to proved a set of users (userSet) matching the criteria specified by adding options to the query.
 * It is entirely possible to build a query object that is invalid and will always return 0 users.  For example by
 * adding options that rresult in an impossible condition, such as users 'created after now' etc.  the developer must use caution.
 *
 * Example Usage:
 * <pre><code>$query = $feu->create_new_query()
 * $query->add_and_opt(feu_user_query_opt::MATCH_NOTDISABLED);
 * $query->add_and_opt(feu_user_query_opt::MATCH_NOTEXPIRED);
 * $query->add_and_opt(new feu_user_query_opt(feu_user_query_opt::MATCH_GROUP,'users'));
 * $user_set = $feu->get_query_results($query);
 * foreach( $user_set as $user ) {
 *   echo $user->username."\n";
 * }
 * </pre></code>
 */
class feu_user_query extends Filter
{
    /**
     * @ignore
     */
    const RESULT_TYPE_ID = '*id*';
    /**
     * @ignore
     */
    const RESULT_TYPE_COUNT = '*count*';
    /**
     * @ignore
     */
    const RESULT_TYPE_LIST = '*list*';
    /**
     * @ignore
     */
    const RESULT_TYPE_FULL = '*full*';

    /**
     * Indicates that the resulting userSet sorts users in ascending order.
     *
     * @see set_sortorder()
     */
    const RESULT_SORTORDER_ASC = '*asc*';

    /**
     * Indicates that the resulting userSet sorts users in descending order.
     *
     * @see set_sortorder()
     */
    const RESULT_SORTORDER_DESC = '*desc*';

    /**
     * Indicates tha the resulting userSet sorts users by their username.
     *
     * @see set_sortby()
     */
    const RESULT_SORTBY_USERNAME = '*username*';

    /**
     * Indicates tha the resulting userSet sorts users by the date the user object was created.
     *
     * @see set_sortby()
     */
    const RESULT_SORTBY_CREATED = '*createdate*';

    /**
     * Indicates tha the resulting userSet sorts users by the expiry date.
     *
     * @see set_sortby()
     */
    const RESULT_SORTBY_EXPIRES = '*expires*';

    /**
     * @ignore
     */
    private $_and_opts   = [];
    /**
     * @ignore
     */
    private $_sortby = self::RESULT_SORTBY_USERNAME;
    /**
     * @ignore
     */
    private $_sortorder = self::RESULT_SORTORDER_ASC;

    /**
     * Construct a new query.
     */
    public function __construct()
    {
        parent::__construct( [ 'limit'=>100000, 'offset'=>0 ] );
    }

    /**
     * Sets the maximum size of resultset that should be returned.  By default the value is 100,000
     * which could be very memory intensive.
     *
     * @param int $pagelimit A value between 1 and 100000 is required.
     */
    public function set_pagelimit(int $pagelimit)
    {
        $pagelimit = max(1,min(100000,$pagelimit));
        $this->adjust('limit',$pagelimit);
    }

    /**
     * Return the current pagelimit
     *
     * @return int
     */
    public function get_pagelimit() : int
    {
        return $this->limit;
    }

    /**
     * Set the current offset within matched users to return.
     *
     * @param int $offset A value that is 0 or greater.
     */
    public function set_offset(int $offset)
    {
        $offset = max(0,$offset);
        $this->adjust('offset',$offset);
    }

    /**
     * Get the current offset.
     *
     * @return int
     */
    public function get_offset() : int
    {
        return $this->offset;
    }

    /**
     * @ignore
     */
    public function set_deep($flag = TRUE)
    {
        // does nothing
    }

    /**
     * @ignore
     */
    public function get_deep()
    {
        return true;
    }

    /**
     * @ignore
     */
    public function set_webready($flag = TRUE)
    {
        // does nothing
    }

    /**
     * @ignore
     */
    public function get_webready()
    {
        // does nothing
    }

    /**
     * @ignore
     */
    public function set_result_type($type)
    {
        // does nothing
    }

    /**
     * @ignore
     */
    public function get_result_type()
    {
        // does nothing
    }

    /**
     * Set a sorting for the resulting userSet.
     * The default is to sort by username.
     *
     * @param string $sortby One of feu_user_query::RESULT_SORTBY_USERNAME, feu_user_query::RESULT_SORTBY_CREATED or feu_user_query::RESULT_SORTBY_EXPIRES
     */
    public function set_sortby(string $sortby)
    {
        switch( $sortby ) {
        case self::RESULT_SORTBY_USERNAME:
        case self::RESULT_SORTBY_CREATED:
        case self::RESULT_SORTBY_EXPIRES:
            $this->_sortby = $sortby;
            break;

        default:
            throw new \InvalidArgumentException('Invalid sortby value: '.$val);
        }
    }

    /**
     * Get the current sortby value.
     *
     * @return string
     */
    public function get_sortby() : string
    {
        return $this->_sortby;
    }

    /**
     * Set the sort order.
     *
     * @param string $val either feu_user_query::RESULT_SORTORDER_ASC or feu_user_query::RESULT_SORTORDER_DESC
     */
    public function set_sortorder($val)
    {
        switch( $val ) {
        case self::RESULT_SORTORDER_ASC:
        case self::RESULT_SORTORDER_DESC:
            $this->_sortorder = $val;
            break;

        default:
            throw new CmsException('Invalid sortorder value: '.$val);
        }
    }

    /**
     * Get the current sort order
     */
    public function get_sortorder() : string
    {
        return $this->_sortorder;
    }

    /**
     * Add a new match condition to the query.
     * this is a convenience method over feu_user_query::add_and_opt_obj
     *
     * @param string $type The match type.  See feu_user_query_opt
     * @param mixed $value A value or expression that may be required by the match type
     * @param mixed $opt Additional data that may be required by the match type.
     */
    public function add_and_opt($type,$value = null,$opt = null)
    {
        $this->_and_opts[] = new feu_user_query_opt($type,$value,$opt);
    }

    /**
     * Add a new match condition to the query.
     *
     * @param feu_user_query_opt $opt A query option.
     */
    public function add_and_opt_obj(feu_user_query_opt $opt)
    {
        $this->_and_opts[] = $opt;
    }

    /**
     * Return the number of options added to the query.
     *
     * @return int
     */
    public function count_opts() : int
    {
        return count($this->_and_opts);
    }

    /**
     * Retrieve the list of options in the query.
     *
     * @internal
     * @return array
     */
    public function get_opts()
    {
        return $this->_and_opts;
    }

    /**
     * Execute the query and return a userSetj
     *
     * @deprecated
     * @returns userSet
     */
    public function execute() : userSet
    {
        // todo: fix me.
        @trigger_error(__METHOD__.' is deprecated Please inform the module administrator, consider sponsoring him to fix this');
        $mod = cmsms()->GetModuleInstance(MOD_FRONTENDUSERS);
        return $mod->get_query_results($this);
    }

} // end of class
