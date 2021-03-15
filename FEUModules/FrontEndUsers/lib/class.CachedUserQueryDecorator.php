<?php
declare(strict_types=1);
namespace FrontEndUsers;
use cms_cache_driver as cache_driver;
use feu_user_query;
use feu_user_query_opt;

/**
 * This decorator is used to cache the results of queries in some external caching mechanism
 *
 * The idea is that dependant modules that are building user queries will use the same queries regularly
 * and therefore it would be useful for them to be cached.
 *
 * Query results are very fragile... whenever any user is modified, rather than determining WHICH quries can be cleared
 * this class clears all cached quries.  So, for stable installs this class can dramatically improve performance
 * for very dynamic sites it can be detremental to performance.
 */
class CachedUserQueryDecorator extends UserManipulatorInterface
{
    private $cache_driver;

    public function __construct(UserManipulatorInterface $parent, cache_driver $driver)
    {
        parent::__construct($parent);
        $this->cache_driver = $driver;
    }

    public function DeleteUserFull(int $uid) : array
    {
        $this->cache_driver->clear();
        return $this->parent->DeleteUserFull($uid);
    }

    public function SetUser(int $uid,string $username,string $password,int $expires = null) : array
    {
        $this->cache_driver->clear();
        return $this->parent->SetUser($uid, $username, $password, $expires);
    }

    public function SetUserDisabled(int $uid, bool $flag = true)
    {
        $this->cache_driver->clear();
        return $this->parent->SetUserDisabled($uid, $flag);
    }

    public function AssignUserToGroup(int $uid, int $gid) : bool
    {
        $this->cache_driver->clear();
        return $this->parent->AssignUserToGroup($uid, $gid);
    }

    public function RemoveUserFromGroup(int $uid, int $gid) : array
    {
        $this->cache_driver->clear();
        return $this->parent->RemoveUserFromGroup($uid, $gid);
    }

    public function SetUserGroups(int $uid, array $grpids = null) : array
    {
        $this->cache_driver->clear();
        return $this->parent->SetUserGroups($uid, $grpids);
    }

    public function DeleteUserPropertyFull(string $title, int $uid, bool $all=false) : bool
    {
        $this->cache_driver->clear();
        return $this->parent->DeleteUserPropertyFull($title, $uid, $all);
    }

    public function SetUserProperties(int $uid, array $props = null) : bool
    {
        $this->cache_driver->clear();
        return $this->parent->SetUserProperties($uid, $props);
    }

    public function SetUserPropertyFull(string $title,string $data,int $uid) : bool
    {
        $this->cache_driver->clear();
        return $this->parent->SetUserPropertyFull($title, $data, $uid);
    }

    public function LogoutUser(int $uid = null)
    {
        $this->cache_driver->clear();
	return $this->parent->LogoutUser($uid);
    }

    public function get_query_results(feu_user_query $query) : userset
    {
        // here is the magic.
        $sig = md5(__FILE__.serialize($query));
        $results = $this->cache_driver->get($sig);
        if( ! $results instanceof userSet ) {
            $results = $this->parent->get_query_results($query);
            $this->cache_driver->set($sig,$results);
        }
        return $results;
    }
} // class
