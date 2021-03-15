<?php

/**
 * This file describes Authorization Tokens
 *
 * @package FrontEndUsers
 * @category Users/Groups
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2019 by Robert Campbell
 */
declare(strict_types=1);
namespace FrontEndUsers;
use JsonSerializable;

/**
 * A class to represent an authorization token.
 * An authorization token is what indicates that a standard user is authorized to use the system.
 *
 * an authtoken is sent to the client on login, and then sent from the client to the server when a resource that requires authorization
 * is requested.  or as a cookie.
 *
 * @property-read int $uid The uid that the token is for
 * @property-read string $code The unique authorization code
 * @property-read int $last_updated The timestamp when this token was last updated
 * @property-read int $expires The timestamp when this token expires
 * @property-read int $created The timestamp when this token was created
 */
class AuthToken implements JsonSerializable
{
    /**
     * @ignore
     */
    private $_data = [ 'uid'=>null, 'code'=>null, 'last_updated'=>null, 'expires'=>null, 'created'=>null ];

    /**
     * @ignore
     */
    protected function __construct() {}

    /**
     * @ignore
     */
    public function __get(string $key)
    {
        switch( $key ) {
        case 'code':
            if( !is_null($this->_data[$key]) ) return trim($this->_data[$key]);
        case 'uid':
        case 'last_updated':
        case 'expires':
        case 'created':
            if( !is_null($this->_data[$key]) ) return (int) $this->_data[$key];
            break;
        case 'expired':
            return $this->expires < time();
        default:
            throw new \LogicException("$key is not a gettable member of ".__CLASS__);
        }
    }

    /**
     * @ignore
     */
    public function __set(string $key, $val)
    {
        throw new \LogicException("$key is not a settable member of ".__CLASS__);
    }

    /**
     * Test whether this authorization token is a 'long term' token
     * i.e: its duration is 2 days or longer
     */
    public function is_longterm() : bool
    {
        // test if this is a long term (rememberme) token
        $twodays = 48 * 3600;
        return $this->expires - $this->created > $twodays;
    }

    /**
     * Convert this object to an array
     *
     * @internal
     */
    public function to_array() : array
    {
        return $this->_data;
    }

    /**
     * @ignore
     */
    public function JsonSerialize()
    {
        return $this->_data;
    }

    /**
     * Create an AuthToken object from an array.
     *
     * @internal
     */
    public static function from_array(array $in) : AuthToken
    {
        $obj = new self;
        foreach( $in as $key => $val ) {
            switch( $key ) {
            case 'uid':
                $obj->_data[$key] = (int) $val;
                break;
            case 'code':
                if( !is_null($val) ) $val = trim($val);
                $obj->_data[$key] = $val;
                break;
            case 'last_updated':
            case 'expires':
            case 'created':
                if( !is_null($val) ) $val = (int) $val;
                $obj->_data[$key] = $val;
                break;
            }
        }
        if( $obj->_data['uid'] < 1 || !$obj->_data['code'] || !$obj->_data['expires'] ) throw new \InvalidArgumentException('Invalid data passed to '.__METHOD__);
        return $obj;
    }
} // class
