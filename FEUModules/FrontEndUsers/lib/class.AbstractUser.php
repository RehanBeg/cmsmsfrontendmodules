<?php
/**
 * This file describes an abstract user class.
 *
 * @package FrontEndUsers
 * @category Users/Groups
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2019 by Robert Campbell
 */

declare(strict_types=1);
namespace FrontEndUsers;
use ArrayAccess;

/**
 * An abstract class that provides array access simulation to the properties of users.
 *
 * @package FrontEndUsers
 */
abstract class AbstractUser implements UserInterface, ArrayAccess
{
    /**
     * @ignore
     */
    public function OffsetGet($key) { return $this->__get($key); }

    /**
     * @ignore
     */
    public function OffsetSet($key,$val) { /* do nothing */ }

    /**
     * @ignore
     */
    public function OffsetUnset($key) { /* do nothing */ }

    /**
     * @ignore
     */
    public function OffsetExists($key)
    {
        $tmp = $this->$key;
        return $tmp !== null;
    }

    /**
     * @ignore
     */
    public function __set(string $key, $val)
    {
        throw new \LogicException("$key is not a settable member of ".__CLASS__);
    }

} // class
