<?php
namespace CGFEURegister;

abstract class AbstractVerifierDecorator
{
    protected $parent;

    public function __construct(RegistrationVerifierInterface $parent = null)
    {
        // note: we want to use a specific interface here.
        $this->parent = $parent;
    }

    // this is an empty type so far.
	public function __call(string $method, $args)
	{
        if( !$this->parent ) {
            throw new \LogicException(get_class($this).' does not have a method entitled '.$method);
        }
	    return call_user_func_array( [ $this->parent, $method ], $args );
    }
} // class