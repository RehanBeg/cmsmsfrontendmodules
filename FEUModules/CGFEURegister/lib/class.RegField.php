<?php
namespace CGFEURegister;
use cge_array;

class RegField
{
    private $_data = [
        'name'=>null, 'prompt'=>null, 'type'=>null, 'required'=>2, 'options'=>null, 'unique'=>false, 'extra'=>null
        ];

    public function __get(string $key)
    {
        switch( $key ) {
        case 'name':
        case 'prompt':
            return trim($this->_data[$key]);
        case 'type':
        case 'required':
            return (int) $this->_data[$key];
        case 'unique':
            return (bool) $this->_data[$key];
        case 'options':
            return $this->_data[$key];
        case 'extra':
            return $this->_data[$key];
        default:
            throw new \LogicException("$key is not a gettable property of ".__METHOD__);
        }
    }

    public function __set(string $key, $val)
    {
        throw new \LogicException("$key is not a settable property of ".__METHOD__);
    }

    public static function from_array( array $in ) : RegField
    {
        $obj = new self;
        foreach( $in as $key => $val ) {
            switch( $key ) {
            case 'name':
            case 'prompt':
                $obj->_data[$key] = trim($val);
                break;
            case 'type':
            case 'required':
                $obj->_data[$key] = (int) $val;
                break;
            case 'options':
                if( is_array($val) && !empty($val) ) {
                    $tmp = $val;
                    if( isset($val[0]) && is_array($val[0]) && isset($val[0]['option_name']) ) {
                        $tmp = null;
                        foreach( $val as $rec ) {
                            $tmp[$rec['option_name']] = $rec['option_text'];
                        }
                        $val = $tmp;
                    }
                    $obj->_data[$key] = $val;
                }
                break;
            case 'extra':
                if( cge_array::is_hash($val) ) $obj->_data[$key] = $val;
                break;
            case 'unique':
                $this->_data[$key] = cms_to_bool($val);
                break;
            }
        }

        // validate
        if( !$obj->name ) throw new \InvalidArgumentException('Every RegField must have a name');
        if( !$obj->prompt ) throw new \InvalidArgumentException('Every RegField must have a prompt');
        if( $obj->type != -100 && $obj->type < 0 && $obj->type > 8 && $obj->type != 6 ) {
            throw new \InvalidArgumentException('Invalid field type '.$obj->type);
        }
        if( $obj->required != 1 && $obj->required != 2 ) throw new \InvalidArgument('Invalid required value.  must be 1 or 2');
        switch( $obj->type ) {
        case 4: // dropdown
        case 5: // multiselect
        case 7: // radiobtns
            if( !is_array($obj->options) || count($obj->options) < 2 ) throw new \InvalidArgument('dropdown/radio button fields must have at least 2 options');
            break;
        }
        return $obj;
    }
} // class