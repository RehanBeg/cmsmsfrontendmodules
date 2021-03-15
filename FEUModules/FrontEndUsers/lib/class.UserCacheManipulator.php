<?php
declare(strict_types=1);
namespace FrontEndUsers;

class UserCacheManipulator extends UserExpiryManipulator
{
    private $usercache;

    public function get_user(int $uid) : UserInterface
    {
        if( !isset($this->usercache[$uid]) ) {
            $res = parent::get_user($uid);
            if( !$res ) throw new UserNotFoundException('Could not find user at '.__METHOD__);
            $this->usercache[$uid] = $res;
        }
        return $this->usercache[$uid];
    }

    public function DeleteUserFull(int $uid) : array
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::DeleteUserFull($uid);
    }

    public function ForcePasswordChange(int $uid, bool $flag = true)
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::ForcePasswordChange($uid, $flag);
    }

    public function ForceChangeSettings(int $uid, bool $flag = true)
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::ForcePasswordChange($uid, $flag);
    }

    public function ForceVerify(int $uid, bool $flag = true)
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::ForceVerify($uid, $flag);
    }

    public function SetUser(int $uid,string $username,string $password,int $expires = null) : array
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::SetUser($uid, $username, $password, $expires);
    }

    public function SetUserDisabled(int $uid, bool $flag = true)
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::SetUserDisabled($uid, $flag);
    }

    public function RemoveUserTempCode(int $uid) : bool
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::RemoveUserTempCode($uid);
    }

    public function SetUserPassword(int $uid,string $password) : array
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::SetUserPassword($uid, $password);
    }

    public function SetUserTempCode(int $uid, string $code) : bool
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::SetUserTempCode($uid, $code);
    }

    public function AssignUserToGroup(int $uid, int $gid) : bool
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::AssignUserToGroup($uid, $gid);
    }

    public function RemoveUserFromGroup(int $uid, int $gid) : array
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::RemoveUserFromGroup($uid, $gid);
    }

    public function SetUserGroups(int $uid, array $grpids = null) : array
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::SetUserGroups($uid, $grpids);
    }

    public function DeleteUserPropertyFull(string $title, int $uid, bool $all=false) : bool
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::DeleteUserPropertyFull($title, $uid, $all);
    }

    public function SetUserProperties(int $uid, array $props = null) : bool
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::SetUserProperties($uid, $props);
    }

    public function SetUserPropertyFull(string $title,string $data,int $uid) : bool
    {
        if( isset($this->usercache[$uid]) ) unset($this->usercache[$uid]);
        return parent::SetUserPropertyFull($title, $data, $uid);
    }

} // class
