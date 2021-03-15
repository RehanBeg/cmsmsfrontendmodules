<?php
namespace CGFEURegister;
use FrontEndUsers;
use cge_param;

class Settings
{
    private $_data = [
        'username_whitelist'=>null, 'username_blacklist'=>null, 'login_after_verify'=>false,
        'verifycode_expire_hours' => 0, 'username_is_email'=>null, 'user_expire_hours' => 0,
        'expireage_months' => 0, 'disable_repeatcode'=>null,
        'onregister_notify_admingroup'=>null, 'nopush_notify_admingroup'=>null,
        'use_builtin_notifications'=>false,
        ];

    public function __construct( $opts )
    {
        if( !is_array($opts) && ! $opts instanceof \cms_config ) throw new \InvalidArgumentException('Invalid input passed to '.__METHOD__);

        $this->_data['login_after_verify'] = cge_param::get_bool($opts,'cgfr_login_after_verify',false);
        $this->_data['use_builtin_notifications'] = cge_param::get_bool($opts,'cgfr_use_builtin_notifications',false);
        $this->_data['username_whitelist'] = cge_param::get_string($opts,'cgfr_username_whitelist');
        $this->_data['username_blacklist'] = cge_param::get_string($opts,'cgfr_username_blacklist');
        $this->_data['onregister_notify_admingroup'] = cge_param::get_string($opts,'cgfr_onregister_notify_admingroup');
        $this->_data['onpush_notify_admingroup'] = cge_param::get_string($opts,'cgfr_onpush_notify_admingroup');
        $this->_data['disable_repeatcode'] = cge_param::get_bool($opts,'cgfr_disable_repeatcode', false);
        $this->_data['verifycode_expire_hours'] = cge_param::get_string($opts,'cgfr_verifycode_expire_hours', 24 * 7);
        $this->_data['remindusers_after_hours'] = cge_param::get_int($opts,'cgfr_remindusers_after_hours', 24);  // one day
        $this->_data['repeatcode_page'] = cge_param::get_string($opts,'cgfr_repeatcode_page');
        $this->_data['user_expire_hours'] = cge_param::get_string($opts,'cgfr_user_expire_hours', 24 * 7); // one week
        $this->_data['username_is_email'] = cge_param::get_bool($opts, 'feu_username_is_email', true);
        $this->_data['expireage_months'] = cge_param::Get_int($opts, 'feu_expireage_months', 520);

        if( $this->verifycode_expire_hours > $this->user_expire_hours ) throw new \InvalidArgumentException('cgfr_verifycode_expire_hours greater than cgfr_user_expire_hours');
        if( $this->expireage_months < 1 ) throw new \InvalidArgumentException('feu_expireage_months has an invalid value');
    }

    public function __get(string $key)
    {
        switch( $key ) {
        case 'login_after_verify':
        case 'username_is_email':
        case 'disable_repeatcode':
        case 'use_builtin_notifications':
            return (bool) $this->_data[$key];
        case 'username_whitelist':
        case 'username_blacklist':
        case 'onregister_notify_admingroup';
        case 'onpush_notify_admingroup';
        case 'repeatcode_page':
            if( !is_null($this->_data[$key]) ) return trim($this->_data[$key]);
            break;
        case 'verifycode_expire_hours':
        case 'user_expire_hours':
        case 'expireage_months':
        case 'remindusers_after_hours':
            return max(0, (int) $this->_data[$key]);
        default:
            throw new \LogicException("$key is not a gettable property of ".__CLASS__);
        }
    }

    public function __set(string $key, $val)
    {
        throw new \LogicException("$key is not a settable property of ".__CLASS__);
    }
} // class