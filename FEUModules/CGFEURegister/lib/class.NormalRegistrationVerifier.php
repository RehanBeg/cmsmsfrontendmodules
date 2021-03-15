<?php
namespace CGFEURegister;
use CGFEURegister;
use FrontEndUsers;
use CMSMS\Database\Connection as Database;


class NormalRegistrationVerifier extends AbstractVerifierDecorator
    implements RegistrationVerifierInterface
{
    private $mod;
    private $feu;
    private $db;

    public function __construct(CGFEURegister $mod, FrontEndUsers $feu, Database $db)
    {
        $this->mod = $mod;
        $this->feu = $feu;
        $this->db = $db;
    }

    protected function is_usernameUsed(string $username, int $uid = null) : bool
    {
        // check our existing database
        if( !$username ) throw new \InvalidArgumentException('Invalid username passed to '.__METHOD__);
        $sql = 'SELECT id FROM '.$this->mod->users_table_name().' WHERE username = ?';
        $parms = [ $username ];
        if ($uid >  0) {
            $sql .= ' AND id != ?';
            $parms[] = $uid;
        }
        $res = $this->db->GetOne($sql, $parms);
        if( $res ) return true;

        $uid = $this->feu->GetUserID($username);
        if( $uid > 0 ) return true;
        return false;
    }

    public function validate_pure_registration(RegFieldSet $fields, User $user)
    {
        $username = $user->get($user::USERNAME_FIELD);
        if( !$username ) throw new ValidationError($this->mod->Lang('err_missing_username'));

        if( !$this->feu->IsValidUsername($username) ) throw new ValidationError($this->mod->Lang('err_invalid_username'));
        if( $this->is_usernameUsed($username, $user->id) ) throw new ValidationError($this->mod->Lang('err_username_exists'));

        // validate that required properties are set
        // validate that property values are valid
        // validate any properties that need to be unique
        foreach( $fields as $field ) {
            $name = $field->name;
            $val = $user->get($name);
            if( $field->required == -100 ) continue; // no validation against internal data values, independent of type.
            if( $field->required == 2 && !$val ) throw new ValidationError($this->mod->Lang('err_required_field', $field->prompt));

            switch( $field->type ) {
            case 2: // email
                if( $val && !is_email($val) ) throw new ValidationError($this->mod->Lang('err_invalid_field', $field->prompt));
                if( $field->unique && !$this->feu->IsUserPropertyValueUnique(null,$name,$val) ) {
                    throw new ValidationError($this->mod->Lang('err_nonunique_field', $field->prompt, $field->value));
                }
                break;
            case 4: // dropdown
            case 7: // radiobtns
                if( $val && !array_key_exists($val,$field->options) ) throw new ValidationError($this->mod->Lang('err_invalid_field',
                                                                                                                 $field->prompt));
                if( $field->unique && !$this->feu->IsUserPropertyValueUnique(null, $name,$val) ) {
                    throw new ValidationError($this->mod->Lang('err_nonunique_field', $field->prompt, $field->value));
                }
                break;
            case 5: // multiselect
                if( $val ) {
                    $diff = array_diff($val,$field->options);
                    if( !empty($diff) ) throw new ValidationError($this->mod->Lang('err_invalid_field', $field->prompt));
                }
                break;
            }
        }
    }

    public function validate_registration(RegFieldSet $fields, User $user)
    {
        $password = $user->get($user::PASSWORD_FIELD);
        $repeat   = $user->get($user::REPEAT_FIELD);

        if( !$password ) throw new ValidationError($this->mod->lang('err_password_required'));
        if( $repeat != $password ) throw new ValidationError($this->mod->Lang('err_password_mismatch'));
        if( !$this->feu->IsValidPassword($password) ) throw new ValidationError($this->mod->Lang('err_invalid_passwordh'));

        $this->validate_pure_registration($fields, $user);
    }
} // class