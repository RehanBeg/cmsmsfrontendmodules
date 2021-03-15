<?php
declare(strict_types=1);
namespace FrontEndUsers;
use CMSMS\HookManager;
use cms_cookies;
use cge_utils;

// this class implements the login, logout, rememberme, and keepalive functionality
// using authtokens
// it uses a cookie (not the session) to store the auth token.
// by default, tokens are enabled for 8 hours and stored as session cookies unuless 'longterm' is enabled
// then the cookie and tokens are enabled for 90 days
// for short term/session tokens, when loggedinid is called, AND the cookie has not been updated for at least 1 hour.. then
// the token expiry is extended to permit continued login as long as the user is active.
//
// users are cached using the file cache to allow for faster processing.
class UserExpiryManipulator extends FrontEndUsersManipulator
{
    private $authentication_proxies = [];

    public function register_authenticator(UserAuthenticator $obj)
    {
        // check to make sure that no other instance of this class is added.
        $class = get_class($obj);
        foreach( $this->authentication_proxies as $proxy ) {
            if( get_class($proxy) == $class ) throw new \InvalidArgumentException('An instance of '.$class.' is already registered');
        }
        $this->authentication_proxies[] = $obj;
    }

    protected function get_auth_tokens_for_user(int $uid)
    {
        $sql = 'SELECT * FROM '.$this->tokens_table_name().' WHERE uid = ? AND expires > ?';
        $arr = $this->GetDb()->GetArray($sql, [ $uid, time() ]);
        $out = null;
        if( !empty($arr) ) {
            foreach( $arr as $row ) {
                $out[] = AuthToken::from_array($row);
            }
        }
        return $out;
    }

    public function create_user(array $in) : UserInterface
    {
        // this builds an AuthTokenUser object that encapsulates a user object... but should be method compatible.
        if( isset($in['id']) && $in['id'] > 0 ) {
            $tmp = $this->get_auth_tokens_for_user((int)$in['id']);
            if( !empty($tmp) ) $in['tokens'] = $tmp;
        }
        return new AuthTokenUser($in);
    }

    public function SetUserLoggedin(int $uid, bool $longterm = false)
    {
        $token_expires = time() + max(1,$this->GetSettings()->authtoken_expiry_hours) * 3600;
        if( $longterm ) $token_expires = strtotime('+90 days');
        $token = $this->create_auth_token($uid,$token_expires);
        $token = $this->save_token($token);
        foreach( $this->authentication_proxies as $proxy ) {
            $proxy->set_login_token($token);
        }
    }

    public function Login(string $username, string $password, string $groups = '', bool $longterm = false) : array
    {
        if( !$username ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        if( !$password ) throw new \InvalidArgumentException('Invalid params passed to '.__METHOD__);
        $uid = -1;
        $mod = $this->GetModule();

        if( !($uid = $this->CheckPassword( $username, $password, $groups )) ) {
            return [ FALSE, $mod->Lang('error_loginfailed') ];
        }
        if( !$this->CanUserLogin($uid) ) return [FALSE, $mod->Lang('error_accountexpired')];
        $this->SetUserLoggedin($uid, $longterm);
        return [TRUE, $uid];
    }

    public function Logout()
    {
        foreach( $this->authentication_proxies as $proxy ) {
            $proxy->remove_authentication($this);
        }
    }

    protected function extend_session_expiry($proxy)
    {
        // calculate a new expiry date
        // have to get the current token AND update it.
        $token = $proxy->get_login_token();
        if( $token && $token instanceof AuthToken && !$token->is_longterm() ) {
            if( $token->last_updated < time() - 3600 ) {
                $new_expires = time() + max(1,$this->GetSettings()->authtoken_expiry_hours) * 3600;
                $token = $this->update_token($token, $new_expires);
                $proxy->set_login_token($token);
            }
        }
    }

    public function LoggedInId()
    {
        foreach( $this->authentication_proxies as $proxy ) {
            try {
                $uid = $proxy->get_current_userid($this);
                if( $uid > 0 && $this->CanUserLogin($uid) ) {
                    // we are logged in.
                    $this->extend_session_expiry($proxy);
                    return $uid;
                }
            }
            catch( UserNotFoundException $e ) {
                // do nothing.
            }
        }
    }

    protected function create_auth_token(int $uid, int $expires) : AuthToken
    {
        // todo: in the future we may have to check if the code generated is not already in use.
        $arr = ['uid'=>$uid, 'expires'=>$expires, 'code'=>cge_utils::create_guid()  ];
        return AuthToken::from_array($arr);
    }

    protected function update_token(AuthToken $token, int $new_expires) : AuthToken
    {
        if( $new_expires <= $token->expires ) throw new \InvalidArgumentException('Invalid new expiry time for auth token');
        $arr = $token->to_array();
        $arr['last_updated'] = time();
        $arr['expires'] = $new_expires;
        $token = AuthToken::from_array($arr);

        $sql = 'UPDATE '.$this->tokens_table_name().' SET expires = ?, last_updated = ? WHERE uid = ? AND code = ?';
        $this->GetDb()->Execute($sql, [ $new_expires, $token->last_updated, $token->uid, $token->code ] );
        return $token;
    }

    protected function save_token(AuthToken $token) : AuthToken
    {
        if( $token->created > 0 ) throw new \InvalidArgumentException('This token has already been saved');
        $created = time();
        $sql = 'INSERT INTO '.$this->tokens_table_name().' (uid, code, last_updated, expires, created) VALUES (?,?,?,?,?)';
        $this->GetDb()->Execute($sql, [ $token->uid, $token->code, $created, $token->expires, $created ]);

        $arr = $token->to_array();
        $arr['created'] = $arr['last_updated'] = $created;
        return AuthToken::from_array($arr);
    }

    public function tokens_table_name() { return CMS_DB_PREFIX.'module_feusers_authtokens'; }
} // class
