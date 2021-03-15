<?php
/**
 * This file describes a user class with concreate data.
 *
 * @package FrontEndUsers
 * @category Users/Groups
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2019 by Robert Campbell
 */

declare(strict_types=1);
namespace FrontEndUsers;
use ArrayAccess;

/**
 * This class describes a FrontEndUsers user object.
 *
 * @package FrontEndUsers
 * @property-read int $id The unique user id, if any
 * @property-read string $username The unique user name, if any
 * @property-read string $password The hashed password, if set
 * @property-read string $salt The old user salt.
 * @property-read string $createdate The datetime string representing when this user was first inserted in the database
 * @property-read string $createdate_ts The unix timestamp of account creation.
 * @property-read string $expires The datetime string represnting when this user account expires and the user can no longer login
 * @property-read int    $expires_ts The unix timestamp of the account expiry.
 * @property-read bool   $expired Whether the user account is already expired.
 * @property-read bool   $nonstd  Indicates whether this user was created by an external authentication module.
 * @property-read bool   $disabled Indicates whether this user account is disabled, preventing login
 * @property-read bool   $force_newpw Indicates whether this user must change his password after the next login
 * @property-read bool   $force_chsettings Indicates whether this user must change his settings after the next login
 * @property-read bool   $must_validate Indicates whether this user must validate his account ownership
 * @property-read array  $props An array of properties
 * @property-read array  $groups An array of gids that this user is a member of
 * @property-read string $verify_code The last verification code for this user, if must_validate is enabled.
 */
class User extends AbstractUser
{
    /**
     * @ignore
     */
    private $_data = [ 'id' => null, 'username' => null, 'createdate' => null, 'expires' => null, 'nonstd' => FALSE, 'disabled' => FALSE, 'force_newpw' => FALSE,
                       'force_chsettings' => FALSE, 'must_validate' => FALSE, 'password'=>null, 'salt'=>null ];
    /**
     * @ignore
     */
    private $_props;

    /**
     * @ignore
     */
    private $_groups;

    /**
     * @ignore
     */
    private $_verify_code;

    /**
     * @ignore
     */
    private $_extra;

    /**
     * Construct a user object given an associative array of properties.
     *
     * Properties:
     *   id (int) A user id.  Must be greater than 0 and not exist if creating a user object that does not exist in the database.
     *   username (string) A unique username for this user, this is used during the login process
     *   password (string) A hashed password.
     *   salt     (string) A password salt.  Only used for very old installs
     *   createdate (string) A database datetime string of the date and time when the record was inserted into the database.
     *   expires  (string) A database datetime string of the date when the user record expires.
     *   onstd    (bool)   Whether this object represents a non-standard account from another authentication mechanism
     *   disabled (bool)   Whether this user is disabled
     *   force_newpw (bool) Whether this user will be forced to change his password on the next login.
     *   force_chsettings (bool) Whether this user will be forced to change settings on the next login
     *   must_validate (bool) Whether this user must verify his email address
     *   props (array) An associative array of properties for this user
     *   groups (array) An array of member gids
     *   verify_code (string) If this user must validate, this is the last tempcode associated with this user.
     *   extra (array) An associative array of Extra data associated with this user (internal)
     *
     * @param array $in The input array.  Possibly the output of the to_array() method
     * @see User::to_array()
     */
    public function __construct(array $in)
    {
        foreach( $in as $key => $val ) {
            switch( $key ) {
            case 'id':
                if( !is_null($val) ) {
                    $val = (int) $val;
                    if( $val < 1 ) throw new \InvalidArgumentException('Invalid id passed to '.__METHOD__);
                }
                $this->_data[$key] = $val;
                break;
            case 'username':
            case 'password':
            case 'salt':
            case 'createdate': // datetime
            case 'expires': // datetime
                if( !is_null($val) ) $this->_data[$key] = trim($val);
                break;
            case 'nonstd':
            case 'disabled':
            case 'force_newpw':
            case 'force_chsettings':
            case 'must_validate':
                $this->_data[$key] = cms_to_bool($val);
                break;
            case 'props':
            case 'groups':
                $kkey = '_'.$key;
                if( is_array($val) && !empty($val) ) $this->$kkey = $val;
                break;
            case 'verify_code':
                if( !is_null($val) ) $this->_verify_code = trim($val);
                break;
            case 'extra':
                if( !is_null($val) && cge_array::is_hash($val) ) $this->_extra = $val;
                break;
            }
        }
    }

    /**
     * @ignore
     */
    public function __get(string $key)
    {
        switch( $key ) {
        case 'id':
            return $this->get_id();

        case 'username':
            return $this->get_username();

        case 'password': // hashed password
        case 'salt': // no longer used after password is changed
            return ( !is_null($this->_data[$key]) ) ? trim($this->_data[$key]) : null;

        case 'createdate_ts':
            return $this->get_createdate();

        case 'createdate':
        case 'createdate_str': // db date
            return trim($this->_data['createdate']);

        case 'expires_ts':
            return $this->get_expires();

        case 'expires':
        case 'expires_str': // db date
            return trim($this->_data['expires']);

        case 'expired':
            return $this->is_expired();

        case 'disabled':
            return $this->is_disabled();

        case 'nonstd':
        case 'force_newpw':
        case 'force_chsettings':
        case 'must_validate':
            return (bool) $this->_data[$key];

        case 'props':
            return $this->_props;

        case 'groups':
            return $this->_groups;

        case 'verify_code':
            return (!is_null($this->_verify_code)) ? trim($this->_verify_code) : null;

        case 'extra':
            return (array)$this->_extra;

        default:
            throw new \LogicException("$key is not a gettable member of ".__CLASS__);
        }
    }

    /**
     * Get the user id if any.
     * This method can return 0 if the object represents a new user
     *
     * @return int
     */
    public function get_id() : int
    {
        return (int) $this->_data['id'];
    }

    /**
     * Get the username, if set
     * The username may be unset if creating a new user and the data has not yet been saved to the database.
     *
     * @param string
     */
    public function get_username() : string
    {
        return ($this->_data['username']) ? trim($this->_data['username']) : '';
    }

    /**
     * Get the unix timestamp where this user was first inserted into the database.
     *
     * @return int
     */
    public function get_createdate() : int
    {
        return ($this->_data['createdate']) ? strtotime($this->_data['createdate']) : 0;
    }

    /**
     * Get the unix timestamp when this user expires
     *
     * @return int
     */
    public function get_expires() : int
    {
        return ($this->_data['expires']) ? strtotime($this->_data['expires']) : 0;
    }

    /**
     * Is this user disabled?
     *
     * @return bool
     */
    public function is_disabled() : bool
    {
        return (bool) $this->_data['disabled'];
    }

    /**
     * Is this user expired?
     *
     * @return bool
     */
    public function is_expired() : bool
    {
        return ($this->expires_ts < time());
    }

    /**
     * Get a single property for user, if it exists.
     * Note: null is also a valid value for an existing property.
     *
     * @param string $key
     * @return string|null
     */
    public function get_property(string $key)
    {
        $key = trim($key);
        if( !$key ) throw new \LogicException('Invalid key passed to '.__METHOD__);
        if( isset($this->_props[$key]) ) return $this->_props[$key];
    }

    /**
     * get an array of all of the properties for the user
     *
     * @return array|null
     */
    public function get_properties()
    {
        return $this->_props;
    }

    /**
     * Get the extra data if any, associated with the user
     *
     * @return array|null
     */
    public function get_extra()
    {
        return $this->_extra;
    }

    /**
     * Test if the user is a member of the specified gid
     *
     * @param int $gid
     * @return bool
     */
    public function memberof(int $gid) : bool
    {
        if( $gid < 1 ) throw new \LogicException('Invalid gid passed to '.__METHOD__);
        if( !is_array($this->_groups) ) return false;
        return in_array($gid,$this->groups);
    }

    /**
     * Convert this object to an array.
     * The array can then be used to create another user object, or to save to a database.
     *
     * @return array
     */
    public function to_array() : array
    {
        $out = $this->_data;
        if( is_array($this->_props) ) $out['props'] = $this->_props;
        if( is_array($this->_groups) ) $out['groups'] = $this->_groups;
        if( $this->_verify_code ) $out['verify_code'] = $this->_verify_code;
        return $out;
    }

} // class
