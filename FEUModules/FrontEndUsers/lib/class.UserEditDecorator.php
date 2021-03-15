<?php
declare(strict_types=1);
namespace FrontEndUsers;
use CMSMS\Database\Connection as Database;

class UserEditDecorator extends UserManipulatorInterface
{
    public function save_user_edit(user_edit_assistant2 $user) : int
    {
        // todo: use a transaction
        $uid = $user->id;
        $mod = $this->GetModule();
        if( $uid < 1 ) {
            // adding a new user
            $ret = $this->AddUser($user->new_username, $user->new_password, $user->expires, $user->nonstd);
            if( !is_array($ret) || $ret[0] == FALSE ) throw new \RuntimeException( $ret[1] );
            $uid = (int) $ret[1];
        } else {
            // updating an existing user
            // allows changing the username,
            $res = $this->SetUser($uid, (string)$user->new_username, (string)$user->new_password, $user->expires);
            if( !is_array($res) || $res[0] == FALSE ) throw new \RuntimeException('Error setting user '.$res[1]);
        }

        // update the 'extra' field for a user.
        /*
        $tmp = null;
        if( is_array($user->extra) ) $tmp = json_encode($tmp);
        $db = $this->GetDb();
        $sql = 'UPDATE '.CMS_DB_PREFIX.'module_feusers_users SET extra = ? WHERE id = ?';
        $db->Execute($sql, [$tmp, $uid]);
        */

        $this->RemoveUserTempCode( $uid );
        $this->SetUserDisabled($uid, $user->disabled);
        $this->ForcePasswordChange($uid, $user->force_newpw);
        $this->ForceChangeSettings($uid, $user->force_chsettings);
        if( $user->id && $user->must_validate && $user->verify_code ) {
            $this->ForceVerify($uid, TRUE);
            $this->SetUserTempCode( $uid, $user->verify_code );
        } else {
            $this->ForceVerify($uid, FALSE);
            $this->RemoveUserTempCode( $uid );
        }

        // add the user to his groups
        $ret = $this->SetUserGroups($uid, $user->groups);
        if( !is_array($ret) || $ret[0] == FALSE ) throw new \RuntimeException($mod->Lang('error_cantassignuser'));

        $res = $this->SetUserProperties($uid, $user->props);
        if( !$res ) throw new \RuntimeException($mod->Lang('error_saveproperties'));
        return $uid;
    }

    public function create_user_edit_assistant(int $uid) : user_edit_assistant2
    {
        $mod = $this->GetModule();
        if ($uid < 1) {
            $user = $this->create_user([]);
            $obj = new user_edit_assistant2($mod, $this->GetSettings(), $user);
            $dflt_group = $this->GetSettings()->default_group;
            $one_group = $this->GetSettings()->require_onegroup;
            $groups = $mod->GetGroupList();
            if( !count($groups) ) throw new \RuntimeException('Could not find any groups... cannot create users');
            $groups = array_flip($groups); // it's backwards for historical reasons.
            if( $dflt_group > 0 ) {
                if( isset($groups[$dflt_group]) ) $obj->set_groups([$dflt_group]);
            } else if( $one_group ) {
                $keys = array_keys($groups);
                $obj->set_groups([$keys[0]]);
            }
            $tmp = $this->GetSettings()->expireage_months;
            $obj->expires = strtotime("+{$tmp} months 00:00");
            if( !$obj->expires || $tmp == 0 ) $this->expires = PHP_INT_MAX;
        } else {
            $user = $this->get_user($uid);
            if( !$user ) throw new \LogicException('Could not find a user with id '.$uid);
            $obj = new user_edit_assistant2($mod, $this->GetSettings(), $user);
            $obj->expires = $user->expires_ts;
        }
        return $obj;
    }

    public function store_user_edit_assistant(user_edit_assistant2 $obj)
    {
        // save the state of the user_edit_assistant2 object
        // do not use searialize as there may be closures in the dependent class
        $data = json_encode($obj->to_array());
        $sig = sha1(__FILE__.$data);
        $str = $sig.'::'.$data;
        $_SESSION[__CLASS__] = $str;
    }

    public function retrieve_user_edit_assistant() : user_edit_assistant2
    {
        // if it is in the session, get the data and clear it
        if( !isset($_SESSION[__CLASS__]) ) throw new \LogicException('No stored user_edit data to decode');
        list($sig,$data) = explode('::',$_SESSION[__CLASS__],2);
        unset($_SESSION[__CLASS__]);
        $verify = sha1(__FILE__.$data);
        if( $sig != $verify ) throw new \LogicException('Could not verify integrity of stored data');
        $data = json_decode($data,TRUE);
        if( !$data ) throw new \LogicException('Could not decode user_edit_asistant state');
        if( !isset($data['user']) ) throw new \LogicException('Could not decode user_edit_asistant state');
        $data['user'] = $this->create_user($data['user']);
        $obj = new user_edit_assistant2($this->GetModule(), $this->GetSettings(), $data);
        return $obj;
    }

} // class
