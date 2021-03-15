<?php
declare(strict_types=1);
namespace FrontEndUsers;
use cms_cookies;
use cge_param;
use CMSMS\Database\Connection as Database;

// this class does not touch the database
// it just handles the cookie data to test if the user is verified.
class BuiltinUserAuthenticator implements UserAuthenticator
{
    private $db;

    public function __construct(Database $db) 
    {
	$this->db = $db;
    }

    // gets browser based login authentication.  either session or cookie or whatever
    public function get_login_token()
    {
        if( ($token = $this->get_cookie_token()) && $token->uid > 0 ) return $token;
    }

    public function set_login_token(AuthToken $token)
    {
        if( $token->uid < 1 ) return;
        if( $token->expires < time() ) {
            $this->remove_cookie_token();
        } else {
            $this->set_cookie_token($token, $token->expires);
        }
    }

    public function get_current_userid(UserManipulator $manip) : int
    {
        if( ($token = $this->get_login_token()) && !$token->expired && $token->uid > 0 ) {
	    $ts = cge_param::get_int($_SESSION,__FILE__);
	    if( time() - $ts > 180 ) {
 		$sql = 'SELECT * FROM '.CMS_DB_PREFIX.'module_feusers_authtokens WHERE uid = ? AND code = ? AND expires > ?';
	        $row = $this->db->GetRow($sql, [$token->uid, $token->code, time()]); 
		if( $row ) {
		    $_SESSION[__FILE__] = time();
                    return $token->uid;
		}
	    } else {
	        return $token->uid;
            }
	}
        return -1;
    }

    public function remove_authentication(UserManipulator $manip)
    {
        if( ($token = $this->get_login_token()) ) {
            $manip->LogoutUser($token->uid);
        }
        $this->remove_cookie_token();
    }

    protected function remove_cookie_token()
    {
        $cookiename = sha1(__FILE__.'FEUKEEPALIVE');
        cms_cookies::erase($cookiename);
    }

    protected function get_cookie_token()
    {
        $cookiename = sha1(__FILE__.'FEUKEEPALIVE');
        $encoded = cms_cookies::get($cookiename);
        if( !$encoded ) return;
        $data = base64_decode($encoded);
        list($sig,$data) = explode('::',$data,2);
        if( !$sig || !$data || sha1(__FILE__.$data) != $sig ) return;
        $data = json_decode($data,TRUE);
        if( !is_array($data) ) return;
        return AuthToken::from_array($data);
    }

    protected function set_cookie_token(AuthToken $token, int $cookie_expires = null)
    {
        if( $cookie_expires < 1 ) $cookie_expires = 0;
        $data = json_encode($token);
        $sig = sha1(__FILE__.$data);
        $cookietext = base64_encode($sig.'::'.$data);
        $cookiename = sha1(__FILE__.'FEUKEEPALIVE');
        cms_cookies::set($cookiename,$cookietext,$cookie_expires);
    }

} // class
