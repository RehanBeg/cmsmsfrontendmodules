<?php
namespace CGFEURegister;

abstract class RegistrationManagerDecorator
{
    protected $parent;

    public function __construct(RegistrationManagerDecorator $parent = null)
    {
        $this->parent = $parent;
    }

    public function __call(string $method, $args)
    {
        if( !$this->parent ) {
            throw new \LogicException(get_class($this).' does not have a method entitled '.$method);
        }
	return call_user_func_array( [ $this->parent, $method ], $args );
    }
} // class
