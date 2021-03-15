<?php
declare(strict_types=1);
namespace FrontEndUsers;
use feu_utils;

class property_editor_defn
{
    private $_propdefn;
    private $_relation;
    private $_user;
    private $_attribs;
    private $_req_color;
    private $_req_marker;
    private $_hidden_color;
    private $_hidden_marker;
    private $_error; // an error key
    private $_tmp1; // some temporary storage data.
    private $_tmp2;

    public function __construct($propdefn,$relation,user_edit_assistant2 &$user, settings $settings)
    {
        if( !isset($propdefn['name']) || !$propdefn['name'] || !isset($propdefn['type']) ) {
            throw new \LogicException('Invalid property def passed to '.__METHOD__);
        }
        if( !isset($relation['name']) || !$relation['name'] || !isset($relation['group_id']) || !$relation['group_id'] ) {
            throw new \LogicException('Invalid property relation passed to '.__METHOD__);
        }
        if( $propdefn['name'] != $relation['name'] ) throw new \LogicException('Mismatched property and relation passed to '.__METHOD__);

        $this->_propdefn = $propdefn;
        $this->_relation = $relation;
        $this->_user =& $user;
        if( isset($this->_propdefn['attribs']) && $this->_propdefn['attribs'] ) $this->_attribs = unserialize($this->_propdefn['attribs']);

        $this->_req_color = $settings->required_field_color;
        $this->_hidden_color = $settings->hidden_field_color;
        $this->_req_marker = $settings->required_field_marker;
        $this->_hidden_marker = $settings->hidden_field_marker;
    }

    public function __get($key)
    {
        $mod = feu_utils::get_mod();

        switch( $key ) {
        case 'name':
            return $this->_propdefn['name'];

        case 'required':
            $v = ($this->_relation['required'] == 2)?true:false;
            return $v;

        case 'prompt':
            return $this->_propdefn['prompt'];

        case 'type':
            return $this->_propdefn['type'];

        case 'color':
            if( $this->required ) {
                return $this->_req_color;
            } else if( $this->_relation['required'] == 3 ) {
                return $this->_hidden_color;
            }
            return;

        case 'unique':
        case 'force_unique':
            return (bool) $this->_propdefn['force_unique'];

        case 'length':
        case 'size':
            if( $this->type == 0 || $this->type == 2 ) return (int) $this->_propdefn['length'];
            return;

        case 'image_path':
            $val = $this->value;
            if( $this->type != 6 || !$val ) return;
            return $mod->get_upload_dirname().'/'.$val;

        case 'image_url':
            $val = $this->value;
            if( $this->type != 6 || !$val ) return;
            return $mod->get_upload_dirurl().'/'.$val;

        case 'maxlength':
        case 'maxlenn':
            if( $this->type == 0 || $this->type == 2 ) return (int) $this->_propdefn['maxlength'];
            return;

        case 'wysiwyg':
            if( $this->type == 3 ) {
                if( isset($this->_attribs['wysiwyg']) ) return $this->_attribs['wysiwyg'];
            }
            return;

        case 'marker':
            if( $this->required ) {
                return $this->_req_marker;
            } else if( $this->_relation['required'] == 3 ) {
                return $this->_hidden_marker;
            }
            return;

        case 'options':
            switch( $this->type ) {
            case 4:
            case 5:
            case 7:
                $opts = feu_utils::get_mod()->GetSelectOptions($this->_propdefn['name']);
                if( !count($opts) ) throw new \RuntimeException('No select options for a dropdown/array property');
                return array_flip($opts);
            default:
                // no array to return.
            }
            return;

        case 'dflt':
        case 'default':
            switch( $this->type ) {
            case 0: // text
            case 2: // email
            case 3: // textarea
            case 4: // dropdown
            case 5: // multiselect
            case 6: // image
            case 7: // radio button group
            case 8: // date
                break;

            case 1: // checkbox
                if( isset($this->_attribs['checked']) ) return $this->_attribs['checked'];
                break;
            }
            return;

        case 'startyear':
        case 'endyear':
            if( $this->type == 8 ) {
                if( isset($this->_propdefn['extra'][$key]) ) return $this->_propdefn['extra'][$key];
            }
            return;

        case 'pattern':
            if( $this->type == 10 ) {
                if( isset($this->_propdefn['extra'][$key]) ) return $this->_propdefn['extra'][$key];
            }
            return;

        case 'placeholder':
            if( isset($this->_propdefn['extra'][$key]) ) return $this->_propdefn['extra'][$key];
            return;

        case 'val':
        case 'value':
            $val = $this->_user->get_property($this->name);
            switch( $this->type ) {
            case 5:
                if( $val && !is_array($val) ) {
                    if( strpos($val,',') !== FALSE )  {
                        $val = explode(',',$val);
                    } elseif( strpos($val,':') !== FALSE ) {
                        $val = explode(':',$val);
                    } else {
                        $val = [ $val ];
                    }
                }
            }
            return $val;
        }
    }

    public function set_value($val)
    {
        $mod = feu_utils::get_mod();

        // $val can be mixed
        switch( $this->type ) {
        case 0: // text field
        case 2: // email
        case 10: // tell
            $val = (string) $val;
            $l = strlen($val);
            $ml = $this->maxlength;
            if( $ml > 0 && $l > $ml ) throw new \CmsInvalidDataException($mod->Lang('error_fldvallength',$this->name).' '.$this->maxlength);
            $this->_user->set_property($this->name,$val);
            break;

        case 1: // checkbox
            $this->_user->set_property($this->name,(int) $val);
            break;

        case 3: // textarea
            $val = (string) $val;
            $this->_user->set_property($this->name,$val);
            break;

        case 4: // dropdown
            $val = (string) $val;
            $this->_user->set_property($this->name,$val);
            break;

        case 5: // multiselect
            if( is_array($val) ) $val = implode(',',$val);
            $this->_user->set_property($this->name,$val);
            break;

        case 6: // image
            // we check if anything is uploaded.
            if( isset($_FILES) && isset($_FILES[$val]) && $_FILES[$val]['name'] ) {
                $this->_tmp1 = $val; // the key
                $this->_tmp2 = $this->_user->get_property($this->name); // current value.
                $newval = $mod->get_upload_filename($this->name,$_FILES[$val]['name']);
                $this->_user->set_property($this->name,$newval);
            }
            break;

        case 7: // radio button group
            $val = (string) $val;
            $this->_user->set_property($this->name,$val);
            break;

        case 8: // date
            $val = (int) $val;
            $this->_user->set_property($this->name,$val);
            break;
        }
    }

    public function validate(int $uid = null)
    {
        if( $uid < 1 ) $uid = null;
        $name = $this->name;
        $val = $this->_user->get_property($name);
        $mod = feu_utils::get_mod();

        if( $this->_error ) throw new \CmsInvalidDataException($mod->Lang($this->_error));
        switch( $this->type ) {
        case 0: // text
            if( !$val && $this->required ) throw new \RuntimeException($mod->Lang('error_missing_required_param',$name));
            if( $val ) {
                $l = strlen($val);
                if( $l > $this->maxlength ) throw new \CmsInvalidDataException($mod->Lang('error_fldvallength',$name));
            }
            break;

        case 2: // email
            if( !$val && $this->required ) throw new \RuntimeException($mod->Lang('error_missing_required_param',$name));
            if( $val ) {
                $l = strlen($val);
                if( $l > $this->maxlength ) throw new \CmsInvalidDataException(feu_utils::get_mod()->Lang('error_fldvallength',$name));
                if( !is_email($val) ) throw new \CmsInvalidDataException(feu_utils::get_mod()->Lang('error_invalidemailaddress'));
            }
            break;

        case 1: // checkbox
            if( $val === '' && $this->required ) throw new \RuntimeException($mod->Lang('error_missing_required_param',$name));
            break;

        case 3: // textarea
            if( $val === '' && $this->required ) throw new \RuntimeException($mod->Lang('error_missing_required_param',$name));
            break;

        case 4: // dropdown
            if( $val === '' && $this->required ) throw new \RuntimeException($mod->Lang('error_missing_required_param',$name));
            break;

        case 5: // multiselect
            if( $val === '' && $this->required ) throw new \RuntimeException($mod->Lang('error_missing_required_param',$name));
            break;

        case 6: // image
            if( $this->_tmp1 ) {
                $ret = feu_utils::checkUpload($this->_tmp1);
                if( !$ret[0] ) throw new \RuntimeException($ret[1]);
            }
            break;

        case 7: // radio button group
            if( $val === '' && $this->required ) throw new \RuntimeException($mod->Lang('error_missing_required_param',$name));
            break;

        case 8: // date
            if( $val < 1 && $this->required ) throw new \RuntimeException($mod->Lang('error_missing_required_param',$name));
            break;
        }

        if( $this->unique ) {
            if( !$mod->IsUserPropertyValueUnique( $uid, $name, $val) ) throw new \RuntimeException($mod->Lang('error_nonunique_field_value',$name,$val));
        }
    }

    public function clear_value()
    {
        switch( $this->type ) {
        case 6: // image
            $mod = feu_utils::get_mod();
            if( $this->value ) {
                // we have an existing iamge
                $path = $mod->get_upload_dirname().'/'.$this->value;
                if( is_file( $path ) ) @unlink($path);
            }
            break;
        }
        $this->_user->set_property($this->name,null);
    }

    public function postprocess($user)
    {
        switch( $this->type ) {
        case 6: // image
            $mod = feu_utils::get_mod();
            if( !$this->_tmp1 ) return;
            if( $this->_tmp2 ) {
                // we have an existing file to get rid of.
                $path = $mod->get_upload_dirname().'/'.$this->_tmp2;
                if( is_file( $path ) ) @unlink($path);
            }
            // now we gotta move the upload from temporary location to permanent location
            $res = $mod->ManageImageUpload($this->_tmp1, $this->name);
        }
    }
}
