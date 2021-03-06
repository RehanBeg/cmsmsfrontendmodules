<?php

/**
 * This file describes a basic interface for describing a user.
 *
 * @package FrontEndUsers
 * @category Users/Groups
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2019 by Robert Campbell
 */

declare(strict_types=1);
namespace FrontEndUsers;

/**
 * A simple interface to describe the minimum functionality required to interact with a user.
 *
 * @package FrontEndusers
 */
interface UserInterface
{
    /**
     * Get a unique identifier for the user.
     *
     * @return int
     */
    public function get_id() : int;

    /**
     * Get the unique username.
     *
     * @return string
     */
    public function get_username() : string;

    /**
     * Get the date that the user was created.
     *
     * @return int A unix timestamp
     */
    public function get_createdate() : int;

    /**
     * Get the date that the user expires.
     *
     * @return int a unix timestamp
     */
    public function get_expires() : int;

    /**
     * Indicates whether or  not the user is disabled.
     *
     * @return bool
     */
    public function is_disabled() : bool;

    /**
     * Test whether the user is expired.
     *
     * @return bool
     */
    public function is_expired() : bool;

    /**
     * Get a piece of data associated with this user
     *
     * @param string $key A key for the data
     * @return mixed  A null value is a valid value.
     */
    public function get_property(string $key);

    /**
     * Get all associated properties for a user.
     *
     * @return array|null Either an associative array, or nothing.
     */
    public function get_properties();

    /**
     * Test whether the user is a member of the specified group
     *
     * @param int $gid
     * @return bool
     */
    public function memberof(int $gid) : bool;

    /**
     * Output the user object as an array
     *
     * @internal
     * @return array
     */
    public function to_array() : array;
} // interface
