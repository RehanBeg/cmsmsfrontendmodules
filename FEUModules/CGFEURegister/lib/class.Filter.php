<?php

/**
 * This file describes an abstract filter class.
 *
 * @package CGFEURegister
 * @category Query/Filter
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2019 by Robert Campbell
 */

namespace CGFEURegister;

/**
 * A class that describes a filter.
 *
 * @prop int $limit The maximum number of items to return  Minimum of 1.
 * @prop int $offset The start position (starting at 0) of items to return.
 */
abstract class Filter
{
    /**
     * @ignore
     */
    private $_data = [ 'limit'=>1000, 'offset'=> 0 ];

    /**
     * Constructor
     *
     * @param array $in An array of input properties.  The abstract class understands the limit, and offset prooperty. both integers.
     */
    protected function __construct( array $in = null )
    {
        if( !is_null($in) ) {
            foreach( $in as $key => $val ) {
                switch( $key ) {
                case 'limit':
                    $this->_data[$key] = max(1,(int)$val);
                    break;
                case 'offset':
                    $this->_data[$key] = max(0,(int)$val);
                    break;
                }
            }
        }
    }

    /**
     * @ignore
     */
    public function __get( string $key )
    {
        switch( $key ) {
        case 'limit':
            return (int) $this->_data[$key];

        case 'offset':
            return (int) $this->_data[$key];

        default:
            throw new \LogicException("$key is not a gettable property of ".get_class($this));
        }
    }

    /**
     * @ignore
     */
    public function __set( string $key, $val )
    {
        throw new \LogicException("$key is not a settable property of ".get_class($this));
    }

    /**
     * A method to adjust the value of a property.
     *
     * @param string $key
     * @param mixed $val
     */
    protected function adjust(string $key, $val)
    {
        switch( $key ) {
        case 'limit':
            $this->_data[$key] = max(1,min(100000,(int)$val));
            break;
        case 'offset':
            $this->_data[$key] = max(0,(int)$val);
            break;
        default:
            throw new \LogicException("$key is not an adjustable property of ".get_class($this));
        }
    }
} // class