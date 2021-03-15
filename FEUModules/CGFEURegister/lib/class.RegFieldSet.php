<?php
namespace CGFEURegister;

class RegFieldSet extends Set
{
    public function __construct( array $matches = null )
    {
        if( is_array($matches) && !empty($matches) ) {
            foreach( $matches as $match ) {
                if( !$match instanceof RegField ) throw new \InvalidArgumentException('Invalid data passed to '.__METHOD__);
            }
        }
        parent::__construct($matches);
    }

    public function has_field(string $key) : bool
    {
        foreach( $this as $field ) {
            if( $field->name == $key ) return true;
        }
        return false;
    }

    public function get_email_field() : RegField
    {
        foreach( $this as $field ) {
            if( $field->type == 2 ) return $field;
        }
        throw new \LogicException('Could not find an email field of type email');
    }
} // class