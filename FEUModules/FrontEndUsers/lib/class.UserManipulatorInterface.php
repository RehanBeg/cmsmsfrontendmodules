<?php
declare(strict_types=1);
namespace FrontendUsers;

abstract class UserManipulatorInterface
{
    protected $parent;

    public function __construct(UserManipulatorInterface $parent = null)
    {
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
} // interface
