<?php
declare(strict_types=1);
namespace FrontEndUsers;
use FrontEndUsers;
use cge_date_utils;
use feu_utils;

// provides convenience mechanisms for editing a user object as the user object itself is immutable.
// this class operats the same as a userinterface object BUT doesn't allow
class user_edit_assistant2
{
    private $new_username;
    private $new_password;     // plain text
    private $repeat_password;  // plain text
    private $user;
    private $mod;
    private $username_is_email;
    private $require_onegroup;
    private $max_passwordlen;
    private $max_usernamelen;

    public function __construct(FrontEndUsers $mod, settings $settings, $data)
    {
        // accept a user object, or an array of state information that contains a user object.
        $this->mod = $mod;
        $this->username_is_email = $settings->username_is_email;
        $this->require_onegroup = $settings->require_onegroup;
        $this->max_passwordlen = $settings->max_passwordlength;
        $this->max_usernamelen = $settings->max_usernamelength;
        if( $data instanceof UserInterface ) {
            $this->user = $data;
        } else if( is_array($data) && array_key_exists('new_password',$data) ) {
            $this->new_username = $data['new_username'];
            $this->new_password = $data['new_password'];
            $this->repeat_password = $data['repeat_password'];
            if( !isset($data['user']) || ! $data['user'] instanceof UserInterface ) {
                stack_trace(); die('test1');
                throw new \InvalidArgumentException('Invalid data passed to '.__METHOD__);
            }
            $this->user = $data['user'];
        }
        else {
            if( is_array($data) ) debug_display('its an array');
            if( isset($data['new_password']) ) debug_display('have password');
            debug_display($data);
            stack_trace(); die('test2');
            throw new \InvalidArgumentException('Invalid data passed to '.__METHOD__);
        }
    }

    public function to_array() : array
    {
        $out = [
            'new_username'=>$this->new_username,
            'new_password'=>$this->new_password,
            'repeat_password'=>$this->repeat_password,
            'user'=>$this->user->to_array()
            ];
        return $out;
    }

    public function __get(string $key)
    {
        switch( $key ) {
        case 'new_username':
            $val = $this->new_username;
            if( !$val ) $val = $this->username;
            return $val;
        case 'new_password':
            return $this->new_password;
        case 'repeat_password':
            return $this->repeat_password;
        case 'expires':
            return $this->user->expires_ts;
        default:
            return $this->user->$key;
        }
    }

    public function __set(string $key, $val)
    {
        switch( $key ) {
        case 'new_username':
            $this->new_username = trim($val);
            break;
        case 'new_password':
            $this->new_password = trim($val);
            break;
        case 'repeat_password':
            $this->repeat_password = trim($val);
            break;
        case 'username':
            $arr = $this->user->to_array();
            $arr[$key] = trim($val);
            $this->user = $this->mod->create_user($arr);
            break;
        case 'expires': // timestamp
            if( $val < 1 ) throw new \InvalidArgumentException('Invalid datetime in attempt to set expires');
            $arr = $this->user->to_array();
            $arr[$key] = cge_date_utils::ts_to_dbformat($val);
            $this->user = $this->mod->create_user($arr);
            break;
        case 'nonstd':
        case 'disabled':
        case 'force_newpw':
        case 'force_chsettings':
            $arr = $this->user->to_array();
            $arr[$key] = cms_to_bool($val);
            $this->user = $this->mod->create_user($arr);
            break;
        case 'must_validate':
            $val = cms_to_bool($val);
            $arr = $this->user->to_array();
            $arr[$key] = $val;
            if( $val ) {
                // need a new verification code
                $arr['verify_code'] = feu_utils::generate_random_printable_string();
            }
            else {
                // need to clear the verification code
                $arr['verify_code'] = null;
            }
            $this->user = $this->mod->create_user($arr);
            break;
        default:
            throw new \LogicException("$key is not a settable member of ".__CLASS__);
        }
    }

    public function memberof(int $gid) : bool
    {
        return $this->user->memberof($gid);
    }

    public function set_groups(array $in = null)
    {
        $arr = $this->user->to_array();
        $arr['groups'] = $in;
        $this->user = $this->mod->create_user($arr);
    }

    public function get_groups()
    {
        return $this->user->groups;
    }

    public function get_property(string $name)
    {
        return $this->user->get_property($name);
    }

    public function set_property(string $name,$val)
    {
        $arr = $this->user->to_array();
        $arr['props'][$name] = $val;
        $this->user = $this->mod->create_user($arr);
    }

    public function create_random_username() : string
    {
        $out = '';
        $suffix = null;
        if( $this->username_is_email ) $suffix = '@junk.localdomain';
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        for( $i = 0; $i < 30; $i++ ) {
            $out .= $upper[rand(0,strlen($upper)-1)];
        }
        return $out.$suffix;
    }

    public function create_random_password() : string
    {
        srand(time());
        $digits = '1234567890';
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower = strtolower($upper);
        $special = '!@#$%^&*(){}[]';
        $all = $digits.$upper.$lower.$special;
        $out = '';
        $out .= $upper[rand(0,strlen($upper)-1)];
        $out .= $digits[rand(0,strlen($digits)-1)];
        $out .= $special[rand(0,strlen($special)-1)];
        for( $i = 0; $i < $this->max_passwordlen - 3; $i++ ) {
            $out .= $all[rand(0,strlen($all)-1)];
        }
        return str_shuffle($out);
    }

    public function can_validate() : bool
    {
        if( $this->id < 1 ) return false;
        if( $this->username_is_email ) return true;

        // see if this user has another email address
        $props = $this->mod->GetMultiGroupPropertyRelations( $this->get_groups() );
        if( empty($props) ) return FALSE;
        $alldefns = $this->mod->GetPropertyDefns();
        $fnd = null;
        foreach( $props as $prop ) {
            $prop_name = $prop['name'];
            if( isset($alldefns[$prop_name]) && $alldefns[$prop_name]['type'] == 2 ) {
                $val = $this->get_property($prop_name);
                if( $val ) return TRUE;
            }
        }
        return FALSE;
    }

    public function validate()
    {
        if( $this->user->id < 1 ) {
            // creating a new user
            if( !$this->mod->IsValidUsername( $this->new_username ) ) throw new \RuntimeException($this->mod->Lang('error_invalidusername'));
            $t_uid = $this->mod->GetUserID($this->new_username);
            if( $t_uid ) throw new \RuntimeException($this->mod->Lang('error_username_exists'));

            // must have a password, and it must be valid
            if( !$this->new_password ) throw new \RuntimeException($this->mod->Lang('error_invalidpassword'));
            if( !$this->mod->IsValidPassword($this->new_password) ) throw new \RuntimeException($this->mod->Lang('error_invalidpassword'));

            // repeat password must be valid.
            if( $this->new_password != $this->repeat_password ) throw new \RuntimeException($this->mod->Lang('error_passwordmismatch'));
        }
        else {
            // editing a user
            if( $this->new_username ) {
                if( !$this->nonstd && !$this->mod->IsValidUsername($this->new_username, FALSE) ) throw new \RuntimeException($this->mod->Lang('error_invalidusername'));
                $t_uid = $this->mod->GetUserID($this->new_username);
                if( $t_uid && $t_uid != $this->user->id ) throw new \RuntimeException($this->mod->Lang('error_username_exists'));
            }

            // if we have a password, it must be valid, and repeat must match
            if( $this->new_password ) {
                if( !$this->mod->isValidPassword($this->new_password) ) throw new \RuntimeException($this->mod->Lang('error_invalidpassword'));

                // repeat password must be valid.
                if( $this->new_password != $this->repeat_password ) throw new \RuntimeException($this->mod->Lang('error_passwordmismatch'));
            }
        }

        // need a valid expiry date when adding/editing a user.
        if( $this->expires_ts < 1 ) throw new \RuntimeException($this->mod->Lang('error_invalidexpirydate'));
        if( $this->must_validate && !$this->verify_code ) throw new \LogicException('Cannot have must validate without a verify code');

        // if require membership in one gruop, make sure we have one.
        if( $this->require_onegroup && (!is_array($this->groups) || !count($this->groups)) ) {
            throw new \Runtimeexception($this->mod->Lang('error_onegrouprequired'));
        }
    }

    public function get_user() : user
    {
        return $this->user;
    }
} // class
