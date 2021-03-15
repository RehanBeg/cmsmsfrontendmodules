<?php
namespace CGFEURegister;
use cge_array;

class UserFilter extends Filter
{
    private $_data = [ 'username_pattern'=>null, 'created_after'=>null, 'created_before'=>null, 'expired'=>null ];

    public function __construct( array $opts )
    {
        if( !cge_array::is_hash($opts) ) throw new \InvalidArgumentException('Invalid data passed to '.__METHOD__);
        parent::__construct($opts);
        foreach( $opts as $key => $val ) {
            switch( $key ) {
            case 'username_pattern':
                $this->_data[$key] = trim($val);
                break;
            case 'created_before':
            case 'created_after':
                $this->_data[$key] = (int) $val;
                break;
            case 'expired':
                $this->_data[$key] = cms_to_bool($val);
                break;
            }
        }
    }

    public function __get(string $key)
    {
        switch( $key ) {
        case 'username_pattern':
            return trim($this->_data[$key]);
        case 'created_before':
        case 'created_after':
            return (int) $this->_data[$key];
        case 'expired':
            return (bool) $this->_data[$key];
        default:
            return parent::__get($key);
        }
    }


} // class