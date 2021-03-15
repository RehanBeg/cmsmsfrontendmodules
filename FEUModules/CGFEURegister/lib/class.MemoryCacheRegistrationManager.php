<?php
namespace CGFEURegister;
use CMSMS\HookManager;

/**
 * This class provides for per-request caching of common information in the Registration Manager
 *
 */
class MemoryCacheRegistrationManager extends RegistrationManager
{
    private $cache = [];
    private $field_cache = [];

    public function save_user(User $user) : User
    {
        $this->cache = [];
        return parent::save_user($user);
    }

    public function delete_user_full( User $user )
    {
        $this->cache = [];
        return parent::delete_user_full($user);
    }

    public function load_user_by_id(int $id)
    {
        if( $id < 1 ) throw new \InvalidArgumentException("invalid id passed to ".__METHOD__);
        if( isset($this->cache[$id]) ) return $this->cache[$id];
        $res = parent::load_user_by_id($id);
        if( $res ) $this->cache[$id] = $res;
        return $res;
    }

    public function get_registration_fields(int $gid) : RegFieldSet
    {
        if( $gid < 1 ) throw new \InvalidArgumentException("invalid gid passed to ".__METHOD__);
        if( isset($this->field_cache[$gid]) ) return $this->field_cache[$gid];
        $res = parent::get_registration_fields($gid);
        if( $res ) $this->field_cache[$gid] = $res;
        return $res;
    }
} // class