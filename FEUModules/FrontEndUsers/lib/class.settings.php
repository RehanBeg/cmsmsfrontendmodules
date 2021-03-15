<?php
declare(strict_types=1);
namespace FrontEndUsers;

class settings
{
    private $_data = [
        'username_is_email' => true,
        'disable_login' => false,
        'disable_forgotpw' => false,
        'disable_lostusername' => false,
        'disable_rememberme' => false,
        'disable_reverify' => false,
        'allow_changeusername' => false,
        'default_group' => null,
        'require_onegroup' => true,
        'min_passwordlength' => 6,
        'max_passwordlength' => 80,
        'enhanced_passwords' => true,
        'password_requiredchars' => '', // '~@#$%^&*=+_-().,!',
        'min_usernamelength' => 3,
        'max_usernamelength' => 128,
        'required_field_marker' => '*',
        'required_field_color' => 'blue',
        'hidden_field_marker' => '!!',
        'hidden_field_color' => 'orange',
        'login_after_verify' => false,
        'expireage_months' => 520,
        'clearhistory_age' => 0,
        'image_destination_path' => '_feusers',
        'allowed_image_extensions' => '.png,.gif,.bmp,.jpg,.jpeg',
        'forcelogout_times' => null,
        'pagetype_groups' => null,
        'pageid_onverify' => null,
        'authtoken_expiry_hours' => 8,
        'tempcode_expiry_days' => 2
        ];

    public function __construct(array $in)
    {
        foreach( $in as $key => $val ) {
            if( startswith($key,'feu_') ) $key = substr($key,4);
            switch( $key ) {
            case 'username_is_email':
            case 'disable_login':
            case 'disable_forgotpw':
            case 'disable_lostusername':
            case 'disable_rememberme':
            case 'disable_reverify':
            case 'allow_changeusername':
            case 'enhanced_passwords':
            case 'login_after_verify':
            case 'require_onegroup':
                $this->_data[$key] = cms_to_bool($val);
                break;
            case 'password_requiredchars':
            case 'required_field_marker':
            case 'required_field_color':
            case 'hidden_field_marker':
            case 'hidden_field_color':
            case 'image_destination_path':
            case 'allowed_image_extensions':
            case 'forcelogout_times':
            case 'pagetype_groups':
            case 'pageid_onverify':
                $this->_data[$key] = trim($val);
                break;
            case 'min_passwordlength':
            case 'max_passwordlength':
            case 'min_usernamelength':
            case 'max_usernamelength':
            case 'clearhistory_age':
            case 'tempcode_expiry_days':
		$this->_data[$key] = (int) $val;
		break;
            case 'default_group':
                $this->_data[$key] = max(0,(int) $val);
                break;
            case 'expireage_months':
                $val = (int) $val;
                if( $val < 1 ) throw new \InvalidArgumentException('feu_expireage_months must be greater than 0');
                $this->_data[$key] = $val;
                break;
            case 'authtoken_expiry_hours':
                $val = (int) $val;
                if( $val < 1 || $val > 7 * 24 ) throw new \InvalidArgmentException('feu_authtoken_expiry_hours must be between 1 and 96 hours');
                $this->_data[$key] = $val;
                break;
            }
        }
    }

    public function __get(string $key)
    {
        switch( $key ) {
        case 'username_is_email':
        case 'disable_login':
        case 'disable_forgotpw':
        case 'disable_lostusername':
        case 'disable_rememberme':
        case 'disable_reverify':
        case 'allow_changeusername':
        case 'enhanced_passwords':
        case 'login_after_verify':
        case 'require_onegroup':
            return (bool) $this->_data[$key];
        case 'password_requiredchars':
        case 'required_field_marker':
        case 'required_field_color':
        case 'hidden_field_marker':
        case 'hidden_field_color':
        case 'image_destination_path':
        case 'allowed_image_extensions':
        case 'forcelogout_times':
        case 'pagetype_groups':
        case 'pageid_onverify':
            return ($this->_data[$key]) ? trim($this->_data[$key]) : null;
        case 'default_group':
        case 'min_passwordlength':
        case 'max_passwordlength':
        case 'min_usernamelength':
        case 'max_usernamelength':
        case 'expireage_months':
        case 'clearhistory_age':
        case 'authtoken_expiry_hours':
        case 'tempcode_expiry_days':
            return (int) $this->_data[$key];
        default:
            throw new \LogicException("$key is not a gettable property of ".__CLASS__);
        }
    }

    public function __set(string $key,$val)
    {
        throw new \LogicException("$key is not a settable property of ".__CLASS__);
    }
} // class
