<?php
declare(strict_types=1);
namespace FrontEndUsers;
use CMSMS\HookManager;
use CMSMS\Database\Connection as Database;
use cge_utils;

/**
 * This class acts as a decorator to the UserManipulator
 * it adds history entries to the history database when various API methods are called
 * and adds a simple add_history method.
 */
class UserHistoryDecorator extends UserManipulatorInterface
{
    private $db;

    public function __construct(UserManipulatorInterface $parent, Database $db)
    {
        parent::__construct($parent);
        $this->db= $db;
    }

    public function add_history(int $uid, string $message)
    {
        $message = trim($message);
        if( $uid < 1 || empty($message) ) throw new \InvalidArgumentException('Invalid arguments passed to '.__METHOD__);

        $query = 'INSERT INTO '.CMS_DB_PREFIX."module_feusers_history (userid,sessionid,action,refdate,ipaddress) VALUES (?,?,?,NOW(),?)";
        $ip = cge_utils::get_real_ip();
        $dbr = $this->db->Execute($query, [$uid, session_id(), substr($message,0,255), $ip]);
        return TRUE;
    }

    protected function audit(int $uid = null, string $message)
    {
        if( $uid < 1 || $uid == null ) $uid = '';
        audit($uid,'FrontEndUsers', $message);
    }

    public function AddUser(string $username, string $password, int $expires, bool $nonstd = FALSE, int $createdate = null) : array
    {
        $res = $this->parent->AddUser($username, $password, $expires, $nonstd, $createdate);
        if( is_array($res) && $res[0] ) {
            $uid = (int) $res[1];
            $this->add_history($uid,'user created');
            $this->audit($uid,'user created');
        }
        return $res;
    }

    public function DeleteUserFull(int $uid) : array
    {
        $res = $this->parent->DeleteUserFull($uid);
        if( is_array($res) && $res[0] ) $this->audit($uid,'User Deleted');
        return $res;
    }

    public function ForcePasswordChange(int $uid, bool $flag = true)
    {
        $this->parent->ForcePasswordChange($uid, $flag);
        if( $flag ) $this->add_history($uid,'forced password change on next login');
    }

    public function ForceChangeSettings(int $uid, bool $flag = true)
    {
        $this->parent->ForceChangeSettings($uid, $flag);
        if( $flag ) $this->add_history($uid,'forced change settings on next login');
    }

    public function ForceVerify(int $uid, bool $flag = true)
    {
        $this->parent->ForceVerify($uid, $flag);
        if( $flag ) $this->add_history($uid,'forced user to verify');
    }

    public function SetUser(int $uid,string $username,string $password,int $expires = null) : array
    {
        $res = $this->parent->SetUser($uid, $username, $password, $expires);
        if( is_array($res) && $res[0] )  $this->add_history($uid,'primary account info adjusted');
        return $res;
    }

    public function SetUserDisabled(int $uid, bool $flag = true)
    {
        $this->parent->SetUserDisabled($uid, $flag);
        if( $flag ) $this->add_history($uid,'user disabled');
    }

    public function SetUserPassword(int $uid, string $password) : array
    {
        $res = $this->parent->SetUserPassword($uid, $password);
        if( is_array($res) && $res[0] )  $this->add_history($uid,'password changed by admin');
        return $res;
    }

    public function AssignUserToGroup( int $uid, int $gid ) : bool
    {
        $res = $this->parent->AssignUserToGroup($uid, $gid);
        if( $res ) $this->add_history($uid,'added to group '.$gid);
        return $res;
    }

    public function RemoveUserFromGroup(int $uid,int $gid) : array
    {
        $res = $this->parent->RemoveUserFromGroup($uid, $gid);
        if( is_array($res) && $res[0] && $res[1] > 0) $this->add_history($uid,"removed from group $gid");
        return $res;
    }

    public function SetUserGroups(int $uid,array $grpids = null) : array
    {
        $res = $this->parent->SetUserGroups($uid, $grpids);
        if( is_array($res) && $res[0] && $res[1] > 0) $this->add_history($uid,"group membership midified");
       return $res;
    }

    public function SetUserLoggedin(int $uid, bool $longterm = false)
    {
        $this->parent->SetUserLoggedIn($uid, $longterm);
        $this->add_history($uid, 'now logged in');
    }

} // class
