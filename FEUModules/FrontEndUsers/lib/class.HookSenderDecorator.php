<?php
declare(strict_types=1);
namespace FrontEndUsers;
use CMSMS\HookManager;
use cge_utils;

class HookSenderDecorator extends UserManipulatorInterface
{
    public function AddUser(string $username, string $password, int $expires, bool $nonstd = false, int $createdate = null)
    {
        $arr = [ 'username'=>$username, 'password'=>$password, 'expires'=>$expires, 'nonstd'=>$nonstd, 'createdate'=>null ];
        HookManager::do_hook('FrontEndusers::BeforeAddUser', $arr );
        $res = $this->parent->AddUser($arr['username'], $arr['password'], $arr['expires'], $arr['nonstd'], $arr['createdate']);
        if( is_array($res) && $res[0] && $res[1] > 0) {
            $arr['uid'] = (int) $res[1];
            HookManager::do_hook('FrontEndusers::AfterAddUser', $arr );
        }
        return $res;
    }

    public function ForcePasswordChange(int $uid, bool $flag = true)
    {
        $this->parent->ForcePasswordChange($uid, $flag);
        HookManager::do_hook('FrontEndUsers::OnUpdateUser', ['id'=>$uid]);
    }

    public function ForceChangeSettings(int $uid, bool $flag = true)
    {
        $this->parent->ForceChangeSettings($uid, $flag);
        HookManager::do_hook('FrontEndUsers::OnUpdateUser', ['id'=>$uid]);
    }

    public function ForceVerify(int $uid, bool $flag = true)
    {
        $this->parent->ForceVerify($uid, $flag);
        HookManager::do_hook('FrontEndUsers::OnUpdateUser', ['id'=>$uid]);
    }

    public function SetUser(int $uid,string $username,string $password,int $expires = null) : array
    {
        $arr = ['uid'=>$uid, 'username'=>$username, 'password'=>$password, 'expires'=>$expires];
        HookManager::do_hook('FrontEndUsers::BeforeUpdateUser', $arr);
        $res = $this->parent->SetUser($uid, $username, $password, $expires);
        if( is_array($res) && $res[0] && $res[1] > 0) HookManager::do_hook('FrontEndUsers::OnUpdateUser', ['id'=>$uid]);
        return $res;
    }

    public function SetUserDisabled(int $uid, bool $flag = true)
    {
        $this->parent->SetUserDisabled($uid, $flag);
        HookManager::do_hook('FrontEndUsers::OnUpdateUser', ['id'=>$uid]);
    }

    public function SetUserPassword(int $uid,string $password)
    {
        $res = $this->parent->SetUserPassword($uid, $password);
        if( is_array($res) && $res[0] && $res[1] > 0) {
            HookManager::do_hook('FrontEndUsers::OnUpdateUser', ['id'=>$uid]);
        }
        return $res;
    }

    public function AssignUserToGroup( int $uid, int $gid ) : bool
    {
        $res = $this->parent->AssignUserToGroup($uid, $gid);
        if( $res ) {
            HookManager::do_hook('FrontEndUsers::OnUpdateUser', ['id'=>$uid]);
        }
        return $res;
    }

    public function RemoveUserFromGroup(int $uid,int $gid) : array
    {
        $res = $this->parent->RemoveUserFromGroup($uid, $gid);
        if( is_array($res) && $res[0] && $res[1] > 0) {
            HookManager::do_hook('FrontEndUsers::OnUpdateUser', ['id'=>$uid]);
        }
        return $res;
    }

    public function SetUserGroups(int $uid,array $grpids = null) : array
    {
        $res = $this->parent->SetUserGroups($uid, $grpids);
        if( is_array($res) && $res[0] && $res[1] > 0) {
            HookManager::do_hook('FrontEndUsers::OnUpdateUser', ['id'=>$uid]);
        }
       return $res;
    }

    public function DeleteUserPropertyFull(string $title, int $uid, bool $all=false) : bool
    {
        $res = $this->parent->DeleteUserPropertyFull($title, $uid, $all);
        if( $res ) {
            HookManager::do_hook('FrontEndUsers::OnUpdateUser', ['id'=>$uid]);
        }
        return $res;
    }

    public function SetUserProperties(int $uid,array $props = null) : bool
    {
        $res = $this->parent->SetUserProperties($uid, $props);
        if( $res ) {
            HookManager::do_hook('FrontEndUsers::OnUpdateUser', ['id'=>$uid]);
        }
        return $res;
    }

    public function SetUserPropertyFull(string $title, string $data, int $uid) : bool
    {
        $res = $this->parent->SetUserPropertyFull($title, $data, $uid);
        if( $res ) {
            HookManager::do_hook('FrontEndUsers::OnUpdateUser', ['id'=>$uid]);
        }
        return $res;
    }

    public function SetUserLoggedin(int $uid, bool $longterm = false)
    {
        $ip = cge_utils::get_real_ip();
        $this->parent->SetUserLoggedin($uid, $longterm);
        HookManager::do_hook('FrontEndUsers::OnLogin', ['id'=>$uid, 'ip'=>$ip]);
    }

    public function DeleteUserFull(int $uid) : array
    {
        $user = $this->get_user($uid);
        if( !$user ) return [FALSE, 'User not found'];

        $parms = ['id'=>$uid, 'username'=>$user->username ];
        HookManager::do_hook('FrontEndUsers::OnDeleteUser',$parms);

        $res = $this->parent->DeleteUserFull($uid);
        if( is_array($res) && $res[0] > 0 ) {
            HookManager::do_hook('FrontEndUsers::AfterDeleteUser',$parms);
        }
        return $res;
    }

    public function Logout(int $uid = null)
    {
        $res = $this->parent->Logout($uid);
        if( $res ) HookManager::do_hook('FrontEndUsers::OnLogout', ['id'=>$uid]);
        return $res;
    }
} // class
