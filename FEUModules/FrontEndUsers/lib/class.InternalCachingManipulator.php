<?php
declare(strict_types=1);
namespace FrontEndUsers;

class InternalCachingManipulator extends UserCacheManipulator
{
    // this caches all the cruft that is NOT related to individual users
    private $multiselect_cache;
    private $propdefn_cache;
    private $group_cache;
    private $groupprop_cache;
    private $useridbyname;

    public function AddSelectOptions(string $name, array $options) : array
    {
        $res = parent::AddSelectOptions($name, $options);
        $this->multiselect_cache = null;
        return $res;
    }

    public function DeleteSelectOptions(string $name) : array
    {
        $this->multiselect_cache = null;
        return parent::DeleteSelectOptions($name);
    }

    public function GetSelectOptions(string $name, int $dim = 1)
    {
        if( $dim != 2 ) $dim = 1;
        $key = $name.$dim;
        if( !isset($this->multiselect_cache[$key]) || !$this->multiselect_cache[$key] ) {
            $res = parent::GetSelectOptions($name, $dim);
            if( $res ) $this->multiselect_cache[$key] = $res;
        }
        return $this->multiselect_cache[$key] ?? null;
    }

    public function GetPropertyDefns()
    {
        if( ! $this->propdefn_cache ) {
            $this->propdefn_cache = parent::GetPropertyDefns();
        }
        return $this->propdefn_cache;
    }

    public function AddPropertyDefn(string $name, string $prompt, int $type, int $length,
                                    int $maxlength = 0, string $attribs = '', bool $force_unique = false, bool $encrypt = false) : array
    {
        $this->propdefn_cache = null;
        return parent::AddPropertyDefn($name, $prompt, $type, $length, $maxlength, $attribs, $force_unique, $encrypt);
    }

    public function DeletePropertyDefn(string $name) : bool
    {
        $this->propdefn_cache = null;
        $this->groupprop_cache = null;
        return parent::DeletePropertyDefn($name);
    }

    public function GetGroupListFull() : array
    {
        if( !$this->group_cache ) {
            $this->group_cache = parent::GetGroupListFull();
        }
        return $this->group_cache;
    }

    public function GetGroupInfo(int $gid)
    {
        $ginfo = $this->GetGroupListFull();
        return $ginfo[$gid] ?? null;
    }

    public function SetGroup(int $id, string $name, string $desc = null) : array
    {
        $this->group_cache = null;
        return parent::SetGroup($id, $name, $desc);
    }

    public function AddGroup(string $name, string $description = null) : array
    {
        $this->group_cache = null;
        return parent::AddGroup($name, $description);
    }

    public function DeleteGroupFull(int $gid) : array
    {
        $this->group_cache = null;
        $this->groupprop_cache = null;
        return parent::DeleteGroupFull($gid);
    }

    public function GetGroupPropertyRelations(int $gid) : array
    {
        if( !isset($this->groupprop_cache[$gid]) ) {
            $this->groupprop_cache[$gid] = parent::GetGroupPropertyRelations($gid);
        }
        return $this->groupprop_cache[$gid];
    }

    public function AddGroupPropertyRelation(int $gid, string $propname, int $sortkey, int $required) : array
    {
        $this->groupprop_cache = null;
        return parent::AddGroupPropertyRelation($gid, $propname, $sortkey, $required);
    }

    public function DeleteAllGroupPropertyRelations(int $gid) : array
    {
        $this->groupprop_cache = null;
        return parent::DeleteAllGroupPropertyRelations($gid);
    }

    public function GetUserID(string $username)
    {
        if( !isset($this->useridbyname[$username]) ) {
            $this->useridbyname[$username] = parent::GetUserID($username);
        }
        return $this->useridbyname[$username];
    }

    public function AddUser(string $name, string $password, int $expires, bool $nonstd = FALSE, int $createdate = null) : array
    {
        $this->useridbyname = null;
        return parent::AddUser($name, $password, $expires, $nonstd, $createdate);
    }

    public function DeleteUserFull(int $id) : array
    {
        $this->useridbyname = null;
        return parent::DeleteUserFull($id);
    }

    public function SetUser(int $uid, string $username, string $password, int $expires = null) : array
    {
        $this->useridbyname = null;
        return parent::SetUser($uid, $username, $password, $expires);
    }

} // class
