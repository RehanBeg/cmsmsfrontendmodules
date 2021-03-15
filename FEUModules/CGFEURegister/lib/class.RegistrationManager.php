<?php
namespace CGFEURegister;
use CMSMS\Database\Connection as Database;
use CGFEURegister;
use FrontEndUsers;
use cge_param;
use cge_encrypt;
use cge_utils;

class RegistrationManager extends RegistrationManagerDecorator
{
    const ENCRYPTION_KEY = 'EncryptionKey';

    private $mod;
    private $feu;
    private $db;
    private $settings;

    public function __construct(CGFEURegister $mod, FrontEndUsers $feu, Database $db, Settings $settings)
    {
        $this->mod = $mod;
        $this->feu = $feu;
        $this->db = $db;
        $this->settings = $settings;
        // do not call parent
    }

    protected function get_encryption_key() : string
    {
        return $this->mod->GetPreference(self::ENCRYPTION_KEY);
    }

    public function create_new_user(RegFieldSet $fields, array $in = null, int $gid = null) : User
    {
        $tmp = [];
        foreach( $fields as $name => $field ) {
            $tmp[$name] = $in[$name] ?? null;
        }
        if( $gid > 0 ) $tmp['gid'] = $gid;
        $user = new User($tmp);
        return $user;
    }

    public function save_user(User $user) : User
    {
        $username = $user->get($user::USERNAME_FIELD);
        $uid = $user->id;

        $data = json_encode($user);
        $encrypted = base64_encode(cge_encrypt::encrypt($this->get_encryption_key(), $data));
        $sig = sha1(__FILE__.$this->get_encryption_key().$encrypted);

        if( $uid < 1 ) {
            // it is an insert
            $now = time();
            $sql = 'INSERT INTO '.$this->mod->users_table_name().' (username, created, sig, data) VALUES (?,?,?,?)';
            $this->db->Execute($sql, [$username, $now, $sig, $encrypted] );
            $new_id = $this->db->Insert_ID();
            // note id and created are not stored with the encrypted data.
            $user = $user->with('id',$new_id)->with('created',$now);
        }
        else {
            // it is an update
            $sql = 'UPDATE '.$this->mod->users_table_name().' SET username = ?, sig = ?, data = ? WHERE id = ?';
            $this->db->Execute($sql, [$username, $sig, $encrypted, $uid] );
        }
        return $user;
    }

    public function delete_user_full( User $user )
    {
        if( $user->id < 1 || $user->created < 1 ) throw new \LogicException('Cannot delete a temp user without a valid id or create date');

        // delete temp codes
        $sql = 'DELETE FROM '.$this->mod->codes_table_name().' WHERE uid = ?';
        $this->db->Execute($sql, [$user->id]);

        // delete the user record.
        $sql = 'DELETE FROM '.$this->mod->users_table_name().' WHERE id = ?';
        $this->db->Execute($sql, [$user->id]);
    }

    public function load_user_by_id(int $id)
    {
        if( $id < 1 ) throw new \InvalidArgumentException("invalid id passed to ".__METHOD__);
        $sql = 'SELECT * FROM '.$this->mod->users_table_name().' WHERE id = ?';
        $row = $this->db->GetRow($sql, [ $id ] );
        if( !$row ) return;

        return $this->create_user_from_row($row);
    }

    protected function create_user_from_row(array $row)
    {
        if( !$row['data'] || !$row['sig'] ) throw new \LogicException('Invalid data found in users table for user '.$id);
        $calc = sha1(__FILE__.$this->get_encryption_key().$row['data']);
        if( $calc != $row['sig'] ) throw new \LogicException('Could not verify signature of database data for user '.$id);
        $decrypted = cge_encrypt::decrypt($this->get_encryption_key(), base64_decode($row['data']));
        if( !$decrypted ) throw new \LogicException('Could not decrypt registration data for user '.$id);
        $decrypted = json_decode($decrypted,TRUE);
        $decrypted['id'] = $row['id'];
        $decrypted['created'] = $row['created'];
        return new User($decrypted);
    }

    public function load_user_by_username(string $username)
    {
        $username = trim($username);
        if( !$username ) throw new \InvalidArgumentException("invalid username passed to ".__METHOD__);
        $sql = 'SELECT * FROM '.$this->mod->users_table_name().' WHERE username = ?';
        $row = $this->db->GetRow($sql, [ $username ]);
        if( !$row ) return;

        return $this->create_user_from_row($row);
    }

    public function is_user_expired(User $user)
    {
        if( !$user->id || !$user->created ) throw new \LogicException('Cannot test if a user is expired without a uid or creratedate');
        if( $this->settings->user_expire_hours < 1 ) return false;
        if( $user->created >= time() - $this->settings->user_expire_hours * 3600 ) return false;
        return true;
    }

    public function push_user_live(RegFieldSet $fields, User $user) : int
    {
        if( !$user->id || !$user->created ) throw new \LogicException('Cannot push user live without a uid or creratedate');
        if( $this->is_user_expired($user) ) throw new \LogicException('Cannot push expired user live');
        if( !$user->password ) throw new \LogicException('A user must have a password to push live');
        if( $user->gid < 1 ) throw new \LogicException('No group associated with temp user');

        $fmt = "+%d months";
        $expires = strtotime(sprintf('+%d months',max(1,$this->settings->expireage_months)));
        if( $expires == 0 ) $expires = PHP_INT_MAX;

        $props = null;
        foreach($fields as $field) {
            if( $field->name == User::USERNAME_FIELD ) continue;
            if( $field->name == User::PASSWORD_FIELD ) continue;
            if( $field->name == User::REPEAT_FIELD ) continue;
            $props[$field->name] = $user->get($field->name);
        }

        $feu_uid = null;
        try {
            $res = $this->feu->AddUser($user->username, $user->password, $expires, false, $user->created);
            if( !is_array($res) || !isset($res[0]) || !$res[0] ) {
                $msg = $res[1] ?? null;
                throw new \LogicException('Problem creating user: '.$msg);
            }
            $feu_uid = (int) $res[1];

            // add him to his group
            $res = $this->feu->AssignUserToGroup($feu_uid, $user->gid);
            if( !$res ) throw new \LogicException('Problem assigning user to group');

            // now add the user properties
            $res = $this->feu->SetUserProperties($feu_uid, $props);
            if( !$res ) throw new \LogicException('Problem setting user properties');
            return $feu_uid;
        }
        catch( \LogicException $e ) {
            if( $feu_uid > 0 ) $this->feu->DeleteUserFull($feu_uid);
            throw $e;
        }
    }

    ////////////////////////////////////////////////////////////

    protected function get_group_properties(int $gid) : array
    {
        if( $gid < 1 ) throw new \InvalidArgumentException('invalid gid passed to '.__METHOD__);
        $defns = $this->feu->GetPropertyDefns();
        if( !count($defns) ) throw new \LogicException('No property definitions found');
        foreach( $defns as &$defn ) {
            // todo: if it is a select field, get the options
            $defn['options'] = $this->feu->GetSelectOptions($defn['name'],2);
        }
        $relns = $this->feu->GetGroupPropertyRelations($gid);
        if( !$relns ) throw new \LogicException('No properties assied to the group '.$gid);

        $out = [];
        foreach( $relns as $reln ) {
            $name = $reln['name'];
            if( !isset($defns[$name]) ) continue;
            if( $defns[$name]['type'] == 6 || $defns[$name]['type'] == 9 ) continue; // image
            if( $reln['required'] != 1 && $reln['required'] != 2) continue;
            $out[$name] = array_merge( $defns[$name], $reln );
        }
        return $out;
    }

    public function get_registration_fields(int $gid) : RegFieldSet
    {
        $username_type = $this->feu->GetUsernameFieldType();
        $out = null;
        $arr = [
            // username is a text field
            'name'=> User::USERNAME_FIELD,
            'prompt'=>($username_type == 2) ? $this->feu->Lang('prompt_email') : $this->feu->Lang('prompt_username'),
            'type'=>$username_type,
            'required'=>2,
            'options'=>null,
            ];
        $out['username'] = RegField::from_array($arr);
        $arr = [
            // password
            'name'=> User::PASSWORD_FIELD,
            'prompt'=>$this->feu->Lang('prompt_password'), 'type'=>-100,
            'required'=>2,
            'options'=>null,
            ];
        $out['password'] = RegField::from_array($arr);
        $arr = [
            // repeat password
            'name'=> User::REPEAT_FIELD,
            'prompt'=>$this->feu->Lang('repeatpassword'), 'type'=>-100,
            'required'=>2,
            'options'=>null,
            ];
        $out['repeatpassword'] = RegField::from_array($arr);
        $props = $this->get_group_properties($gid);
        foreach( $props as $name => $prop ) {
            $out[$name] = RegField::from_array($prop);
        }
        return new RegFieldSet($out);
    }

    public function fill_from_data(RegFieldSet $fieldset, User $user, array $formdata) : User
    {
        foreach( $fieldset as $field ) {
            switch( $field->type ) {
            case -100: // password
            case 0:    // text
            case 1:    // checkbox
            case 2:    // email
            case 10:    // tel
                $user = $user->with($field->name, cms_html_entity_decode(cge_param::get_string($formdata, $field->name)));
                break;
            case 3:    // textarea
                $user = $user->with($field->name, cms_html_entity_decode(cge_param::get_html($formdata, $field->name)));
                break;
            case 4:    // dropdown
            case 7:    // radiobtns
                $user = $user->with($field->name, cms_html_entity_decode(cge_param::get_string($formdata, $field->name)));
                break;
            case 5:    // multiselect
            case 8:    // date
                if( cge_param::exists($formdata, $field->name.'Month') ) {
                    $user = $user->with($field->name, cge_param::get_separated_date($formdata, $field->name));
                } else {
                    $user = $user->with($field->name, strtotime(cge_param::get_date($formdata, $field->name)));
                }
                break;
            }
        }
        return $user;
    }

    /////////////////////////////////////////////////////////////////////

    public function create_registration_code(User $user) : VerificationData
    {
        $expires = ($this->settings->verifycode_expire_hours < 1) ? 0 : $this->settings->verifycode_expire_hours * 3600 + time();
        $arr = [ 'uid'=>$user->get('id'), 'expires'=>$expires, 'verify_code'=>cge_utils::create_guid() ];
        return new VerificationData($arr);
    }

    public function load_verification_code(string $code)
    {
        $code = trim($code);
        if( !$code ) throw new \InvalidArgumentException('Invalid data passed to '.__METHOD__);

        $sql = 'SELECT * FROm '.$this->mod->codes_table_name().' WHERE verify_code = ?';
        $row = $this->db->GetRow($sql, [$code]);
        if( !$row ) return;
        return new VerificationData($row);
    }

    public function save_verification_code(VerificationData $code)
    {
        if( $code->uid < 1 || $code->expires < 0 || !$code->verify_code ) {
            throw new \InvalidArgumentException("Invalid verification code data passed to ".__METHOD__);
        }

        $sql = 'INSERT INTO '.$this->mod->codes_table_name().' (uid, verify_code, expires) VALUES (?,?,?)';
        $this->db->Execute($sql, [$code->uid, $code->verify_code, $code->expires]);
    }

    public function delete_expired_codes()
    {
        $sql = 'DELETE FROM '.$this->mod->codes_table_name().' WHERE expires < ?';
        $this->db->Execute($sql, [time() - 300] );
    }

    /////////////////////////////////////////////////////////////////////

    public function create_user_filter( array $parms = null ) : UserFilter
    {
        if( is_null($parms) ) $parms = [];
        return new UserFilter($parms);
    }

    public function load_users_by_filter(UserFilter $filter) : UserSet
    {
        $sql = 'SELECT SQL_CALC_FOUND_ROWS * FROM '.$this->mod->users_table_name();
        $where = $parms = null;

        if( $filter->username_pattern ) {
            $where[] = 'username LIKE ?';
            $parms[] = $this->wildcard($filter->username_pattern);
        }
        if( $filter->created_before > 0 ) {
            $where[] = 'created < ?';
            $parms[] = $filter->created_before;
        }
        if( $filter->created_after > 0 ) {
            $where[] = 'created > ?';
            $parms[] = $filter->created_after;
        }
        if( $filter->expired && $this->settings->user_expire_hours > 0 ) {
            $where[] = 'created < ?';
            $parms[] = time() - $this->settings->user_expire_hours * 3600;
        }

        if( !empty($where) ) $sql .= ' WHERE '.implode(' AND ',$where);

        $rs = $this->db->SelectLimit($sql, $filter->limit, $filter->offset, $parms);
        $found_rows = $this->db->GetOne('SELECT FOUND_ROWS()');

        $matches = null;
        while( $rs && !$rs->EOF() ) {
            $matches[] = $this->create_user_from_row($rs->fields);
            $rs->MoveNext();
        }

        return new UserSet($filter, $found_rows, $matches);
    }

} // class
