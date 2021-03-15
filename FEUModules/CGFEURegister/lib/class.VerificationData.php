<?php
namespace CGFEURegister;

class VerificationData
{
    private $_data = ['uid'=>null, 'verify_code'=>null, 'expires'=>null ];

    public function __construct(array $in)
    {
        foreach($in as $key => $val) {
            switch( $key ) {
            case 'uid':
            case 'expires':
                $this->_data[$key] = (int) $val;
                break;
            case 'verify_code':
                $this->_data[$key] = trim($val);
            }
        }

        if( $this->uid < 1 ) throw new \InvalidArgumentException('Invalid data passed to '.__METHOD__);
        if( !$this->verify_code ) throw new \InvalidArgumentException('Invalid data passed to '.__METHOD__);
    }

    public function __get(string $key)
    {
        switch( $key ) {
        case 'uid':
        case 'expires':
            if( !is_null($this->_data[$key]) ) return (int) $this->_data[$key];
            break;
        case 'verify_code':
            if( !is_null($this->_data[$key]) ) return trim($this->_data[$key]);
            break;
        default:
            throw new \LogicException("$key is not a gettable property of ".__CLASS__);
        }
    }

    public function __set(string $key, $val)
    {
        throw new \LogicException("$key is not a settable property of ".__CLASS__);
    }

} // class