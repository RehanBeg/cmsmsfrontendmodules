<?php
namespace CGFEURegister;
use JsonSerializable;
use cge_array;

class User implements JsonSerializable
{
    const USERNAME_FIELD = 'username';
    const PASSWORD_FIELD = 'password';
    const REPEAT_FIELD = 'repeatpassword';
    private $_data = [ 'id'=>null, 'created'=>null ];

    public function __construct( array $in )
    {
        foreach( $in as $key => $val ) {
            switch( $key ) {
            case 'id':
            case 'created':
            case 'gid':
                $this->_data[$key] = (int) $val;
                break;
            default:
                if( !is_null($val) && !is_string($val) && !is_scalar($val) ) throw new \InvalidArgumentException('Invalid property data passed to '.__METHOD__);
                $this->_data[$key] = $val;
            }
        }
    }

    public function __get(string $key)
    {
        return $this->get($key);
    }

    public function __set(string $key, $val)
    {
        throw new \LogicException("$key is not a settable property of ".__CLASS__);
    }

    public function __isset(string $key)
    {
        return isset($this->_data[$key]);
    }

    public function with(string $key, $val) : User
    {
        $key = trim($key);
        if( !$key ) throw new \InvalidArgumentException('Invalid key passed to '.__METHOD__);

        $obj = clone $this;
        switch( $key ) {
        case 'id':
        case 'created':
        case 'gid':
            if( !is_int($val) || $val < 1 ) throw new \InvalidArgumentException("Invalid value for $key passed to ".__METHOD__);
            $obj->_data[$key] = $val;
            break;
        default:
            if( !array_key_exists($key, $this->_data) ) throw new \LogicException("$key is not a settable property of ".__CLASS__);
            if( !is_null($val) && !is_scalar($val) && !is_string($val) ) throw new \InvalidArgumentException("Invalid value for $key passed to ".__METHOD__);
            $obj->_data[$key] = $val;
            break;
        }
        return $obj;
    }

    public function get(string $key)
    {
        $key = trim($key);
        if( !$key ) throw new \InvalidArgumentException('Invalid key '.$key.' passed to '.__METHOD__);
        if( !array_key_exists($key,$this->_data) ) throw new \InvalidArgumentException("Invalid key $key passed to ".__METHOD__);
        return $this->_data[$key];
    }

    public function JsonSerialize()
    {
        return $this->_data;
    }

} // class