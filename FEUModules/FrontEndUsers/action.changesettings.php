<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management of frontend
#  users, and their login process within a CMS Made Simple powered
#  website.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE
// todo: rewrite me.
namespace FrontEndUsers;
use FrontEndUsers;
use cge_param;
use cge_utils;
use CMSMS\HookManager;
if( !isset($gCms) ) exit;

$validate_property = function(int $uid, array $prop, array &$params) {
    $defnsbyname = $this->GetPropertyDefns();
    $propname = $prop['name'];
    $fldtype = $defnsbyname[$propname]['type'];
    $required = ($prop['required'] == 2);
    $hidden   = ($prop['required'] == 3);
    $readonly = ($prop['required'] == 4);

    switch( $fldtype ) {
    case FrontEndUsers::FIELDTYPE_TEXT:
    case FrontEndUsers::FIELDTYPE_TEL:
        if( $required ) {
            if( !isset($params['feu_input_'.$propname]) || empty($params['feu_input_'.$propname]) ) {
                throw new FeuChangeSettingsError( $this->Lang('error_requiredfield', $defnsbyname[$propname]['prompt'] ) );
            }
        }
        break;

    case FrontEndUsers::FIELDTYPE_CHECKBOX:
        if( !isset($params['feu_input_'.$propname]) ) {
            $params['feu_input_'.$propname] = 0;
        }
        if( $required ) {
            if( $params['feu_input_'.$propname] == 0 ) throw new FeuChangeSettingsError( $this->Lang('error_requiredfield', $defnsbyname[$propname]['prompt']) );
        }
        break;

    case FrontEndUsers::FIELDTYPE_EMAIL:
        $eml = cge_utils::get_param($params,'feu_input_'.$propname);
        if( !$eml && $required ) {
            throw new FeuChangeSettingsError( $this->Lang('error_invalidemailaddress') );
        }
        else if( $eml && !is_email($eml) ) {
            throw new FeuChangeSettingsError( $this->Lang('error_invalidemailaddress')." $eml" );
        }
        else {
            $params['feu_input_'.$propname] = $eml;
        }
        break;

    case FrontEndUsers::FIELDTYPE_TEXTAREA:
        if( $required && !isset($params['feu_input_'.$propname]) ) throw new FeuChangeSettingsError( $this->Lang('error_requiredfield', $defnsbyname[$propname]['prompt']) );
        if( $required && empty($params['feu_input_'.$propname]) ) throw new FeuChangeSettingsError( $this->Lang('error_requiredfield', $defnsbyname[$propname]['prompt']) );
        break;

    case FrontEndUsers::FIELDTYPE_MULTISELECT:
        if( $required && !isset($params['feu_input_'.$propname]) ) throw new FeuChangeSettingsError( $this->Lang('error_requiredfield', $defnsbyname[$propname]['prompt']) );
        // encode it into a comma separated list.
        if( isset($params['feu_input_'.$propname]) ) {
            $params['feu_input_'.$propname] = implode(',',$params['feu_input_'.$propname] );
        }
        else {
            $params['feu_input_'.$propname] = '';
        }
        break;

    case FrontEndUsers::FIELDTYPE_IMAGE:
        if( isset($params['feu_input_'.$propname.'_clear']) &&
            $params['feu_input_'.$propname.'_clear'] == 'clear' ) {
            // we're told to clear an image property, we must also
            // delete the image
            $destDir1 = $gCms->config['uploads_path'].'/';
            $destDir1 .= $this->geet_settings()->image_destination_path.'/';
            $file1 = $destDir1.$params['feu_input_'.$propname];
            if( is_file($file1) ) @unlink( $file1 );

            // unset the hidden param to prevent any further processing
            $deleteprops[] = $propname;
            unset( $params['feu_input_'.$propname] );
        }
        if( $required &&
            ((!isset($_FILES[$id.'feu_input_'.$propname]) || $_FILES[$id.'feu_input_'.$propname]['size'] == 0) &&
             (!isset($params['feu_input_'.$propname]) || $params['feu_input_'.$propname] == '')) ) {
            // but we can't find a value
            throw new FeuChangeSettingsError( $this->Lang('error_requiredfield', $propname ) );
        }
        break;

    case FrontEndUsers::FIELDTYPE_DATE:
        if( isset($params['feu_input_'.$propname.'Month']) ) {
            $val = cge_param::get_separated_date($params,'feu_input_'.$propname);
            unset($params['feu_input_'.$propname.'Month']);
            unset($params['feu_input_'.$propname.'Day']);
            unset($params['feu_input_'.$propname.'Year']);
            $params['feu_input_'.$propname] = $val;
        } else {
            $val = cge_param::get_string($params,'feu_input_'.$propname);
            if( preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$val) ) {
                $params['feu_input_'.$propname] = strtotime( $val );
            }
        }
        if( $required && !isset($params['feu_input_'.$propname]) ) throw new FeuChangeSettingsError( $this->Lang('error_requiredfield', $propname ) );
        break;

    case FrontEndUsers::FIELDTYPE_DROPDOWN:
    case FrontEndUsers::FIELDTYPE_RADIOBUTNS:
        if( $required && !isset($params['feu_input_'.$propname]) ) throw new FeuChangeSettingsError( $this->Lang('error_requiredfield', $propname ) );
        break;

    default:
        // we don't accept field types like this
        debug_display($prop); die();
        throw new FeuChangeSettingsError( $this->Lang('error_cantsetpropertytype',$propname) );
        break;
    }

};

try {
    if( $this->config['feu_disable_changesettings'] ) throw new \CmsError403Exception('Permission denied');
    $uid = $this->LoggedInId();
    if( $uid < 1 ) return;
    $thetemplate = cge_param::get_string($params,'changesettingstemplate','orig_changesettings.tpl');
    $user = $this->get_user($uid);
    if( !$user ) throw new \RuntimeException($this->Lang('err_notfound'));
    $password = $repeat = null;
    $username = $user->username;

    $properties = $this->GetMultiGroupPropertyRelations( $user->groups );
    if( empty($properties) && $this->get_settings()->require_onegroup ) throw new \RuntimeException($this->Lang('error_onegrouprequired'));

    $error = $final_message = null;
    if( ($this->session_get('feu_afterpost') == 1) ) {
        $this->session_clear('feu_afterpost');
        $final_message = $this->Lang('msg_settingschanged');
    }
    else if( !empty($_POST) ) {
        class FEUChangeSettingsError extends \RuntimeException {}

        try {
            if( !cge_utils::valid_form_csrf() ) throw new FeuChangeSettingsError( $this->Lang('error_security') );
            $defnsbyname = $this->GetPropertyDefns();
            HookManager::do_hook('FrontEndUsers::BeforeChangeSettings', [ 'uid'=>$uid ] );
            $user = $this->create_user_edit_assistant($uid);

            if( $this->get_settings()->allow_changeusername && !$user->nonstd && ($username = cge_param::get_string($params,'feu_input_username')) ) {
                $username = cms_html_entity_decode($username);
                if( !$this->IsValidUsername($username,FALSE,$uid) ) throw new FeuChangeSettingsError( $this->Lang('error_invalidusername') );
                $user->new_username = $username;
            }

            // password
            if( !$user->nonstd ) {
                $password = cms_html_entity_decode(cge_param::get_string($params,'feu_input_password'));
                $repeat = cms_html_entity_decode(cge_param::get_string($params,'feu_input_repeatpassword'));
                if( $user->force_newpw && !$password ) throw new FeuChangeSettingsError( $this->Lang('error_requiredfield','password') );
                if( $user->force_newpw && !$repeat ) throw new FeuChangeSettingsError( $this->Lang('error_requriedfield','repeatpassword') );
                if( $password != $repeat && $password != '') throw new FeuChangeSettingsError( $this->Lang('error_passwordmismatch') );
                if( $password != '' && !$this->IsValidPassword($password) ) throw new FeuChangeSettingsError( $this->Lang('error_invalidpassword') );
                $user->new_password = $password;
                $user->repeat_password = $repeat;
            }
            $user->force_chsettings = false;

            // do validation of fields.
            foreach( $properties as $prop ) {
                $validate_property($uid,$prop,$params);
            }

            HookManager::do_hook( 'FrontEndUsers::ChangeSettingsAfterValidate', [ 'uid'=>$uid ] );

            // now set the properties of fields
            $props_arr = null;
            foreach( $properties as $prop ) {
                $propname = $prop['name'];
                $fldtype  = $defnsbyname[$propname]['type'];
                $hidden = ($prop['required'] == 3);
                $readonly = ($prop['required'] == 4);
                $force_unique = $defnsbyname[$propname]['force_unique'];
                $val = null;

                if( !isset( $params['feu_input_'.$propname] ) ) continue;
                if( $readonly || $hidden ) continue; // cannot set readonly or hidden fields

                // get a property value
                if( $fldtype == FrontEndUsers::FIELDTYPE_IMAGE ) {
                    if( isset( $_FILES[$id.'feu_input_'.$propname] ) && $_FILES[$id.'feu_input_'.$propname]['size'] > 0) {
                        // It is an upload file type
                        $result = $this->ManageImageUpload($id.'feu_input_'.$propname, $propname );
                        if( $result[0] == false ) throw new \RuntimeException($this->Lang('error').'&nbsp;'.$result[1]);
                        $val = $result[1];
                    }
                }
                else {
                    $val = cge_param::get_string($params,'feu_input_'.$propname);
                    $val = cms_html_entity_decode($val);
                    if ($fldtype == FrontEndUsers::FIELDTYPE_TEXTAREA) {
                        $val = cge_utils::clean_input_html($val);
                    } else {
                        $val = strip_tags($val);
                    }
                }
                $user->set_property($propname,$val);
            }

            // and then, iterate through the properties for further validation
            foreach( $properties as $prop ) {
                $propname = $prop['name'];
                $hidden = ($prop['required'] == 3);
                $force_unique = $defnsbyname[$propname]['force_unique'];

                $val = $user->props[$propname] ?? null;
                if( $val && $force_unique && !$this->IsUserPropertyValueUnique($uid, $propname, $val) ) {
                    throw new \RuntimeException($this->Lang('error_user_nonunique_field_value', $propname));
                }
            }

            $this->save_user_edit($user);
            // redirect after post
            $this->session_put('feu_afterpost',1);
            $this->redirect('cntnt01','changesettings',$returnid);
        }
        catch( \Exception $e ) {
            $error = $e->Getmessage();
        }

        // fall through
    }

    // now we're ready to populate the template
    // first we put in stuff that is required (username, password, etc, etc)
    $rowarray = null;

    if( !$user->nonstd ) {
        $onerow = new \StdClass();
        $onerow->name = 'username';
        $onerow->type = ($this->get_settings()->username_is_email)?2:0;
        $onerow->color = $this->get_settings()->required_field_color;
        $onerow->marker = $this->get_settings()->required_field_marker;
        $onerow->required = 1;
        $onerow->prompt = $this->get_settings()->username_is_email ? $this->Lang('prompt_email') : $this->Lang('prompt_username');
        $onerow->value = $username;
        $onerow->input_id = 'feu_input_username';
        $onerow->input_name = $id.$onerow->input_id;
        $onerow->length = 40; // backwards compat
        $onerow->maxlength = $this->get_settings()->max_usernamelength;
        $onerow->readonly = !$this->get_settings()->allow_changeusername;
        $onerow->pattern = '';
        $onerow->placeholder = '';
        $tmp = 'disabled="disabled"';
        if( !$onerow->readonly ) $tmp = '';
        $rowarray[$onerow->name] = $onerow;
    }

    if( !$user->nonstd ) {
        // can change password
        // and password
        $val = '';
        if( isset( $params['feu_input_password'] ) ) $val = $params['feu_input_password'];
        $onerow = new \StdClass();
        $onerow->name = 'password';
        $onerow->type = 'password';
        $onerow->color = null;
        $onerow->required = ($user->force_newpw) ? 1 : 0;
        $onerow->marker = null;
        if( $onerow->required ) {
            $onerow->color = $this->get_settings()->required_field_color;
            $onerow->marker = $this->get_settings()->required_field_marker;
        }
        $onerow->prompt = $this->Lang('password');
        $onerow->addtext =$this->Lang('info_emptypasswordfield');
        $onerow->value = $password;
        $onerow->input_id = 'feu_input_password';
        $onerow->input_name = $id.$onerow->input_id;
        $onerow->length = 80;
        $onerow->maxlength = $this->get_settings()->max_passwordlength;
        $onerow->readonly = false;
        $onerow->pattern = '';
        $onerow->placeholder = '';
        $rowarray[$onerow->name] = $onerow;

        // and make him repeat the password
        $val = '';
        if( isset( $params['feu_input_repeatpassword'] ) ) $val = $params['feu_input_repeatpassword'];
        $onerow = new \StdClass();
        $onerow->name = 'repeat_password';
        $onerow->type = 'password';
        $onerow->color = null;
        $onerow->marker = null;
        $onerow->required = ($user->force_newpw) ? 1 : 0;
        if( $onerow->required ) {
            $onerow->marker = $this->get_settings()->required_field_marker;
            $onerow->color = $this->get_settings()->required_field_color;
        }
        $onerow->prompt = $this->Lang('repeatpassword');
        $onerow->addtext =$this->Lang('info_emptypasswordfield');
        $onerow->value = $repeat;
        $onerow->input_id = 'feu_input_repeatpassword';
        $onerow->input_name = $id.$onerow->input_id;
        $onerow->length = 80;
        $onerow->maxlength = $this->get_settings()->max_passwordlength;
        $onerow->readonly = false;
        $onerow->pattern = '';
        $onerow->placeholder = '';
        $rowarray[$onerow->name] = $onerow;
    }

    // now for the properties
    foreach( $properties as $prop ) {
        // get the property definition
        $defn = $this->GetPropertyDefn( $prop['name'] );

        if( $prop['required'] == 3 ) continue; // hidden.
        if( $prop['required'] == 9 ) continue; // data

        $onerow = new \StdClass();
        $onerow->name        = $prop['name'];
        $onerow->propname    = $prop['name'];
        $onerow->input_id    = 'feu_input_'.$onerow->propname;
        $onerow->input_name  = $id.$onerow->input_id;
        $val = $this->GetUserPropertyFull( $prop['name'], $uid );
        if( isset($params[$onerow->input_name]) ) $val=$params['feu_'.$onerow->input_name];

        // begin building the object that contains data for building the fields.
        $onerow->type        = $defn['type'];
        $onerow->required    = ($prop['required'] == 2);
        $onerow->readonly    = ($prop['required'] == 4);
        $onerow->status      = $prop['required'];
        $onerow->color       = null;
        $onerow->marker      = null;;
        $onerow->value       = $user->props[$prop['name']] ?? null;
        $onerow->length      = $defn['length']; // backwards compat
        $onerow->maxlength   = $defn['maxlength'];
        $onerow->prompt      = $defn['prompt'];
        if( $onerow->required ) {
            $onerow->color = $this->get_settings()->required_field_color;
            $onerow->marker = $this->get_settings()->required_field_marker;
        }
        $onerow->pattern     = $defn['extra']['pattern'] ?? null;
        $onerow->placeholder     = $defn['extra']['placeholder'] ?? null;

        switch( $defn['type'] ) {
        case 0: // text
            break;

        case 1: // checkbox
            break;

        case 2: // email
            break;

        case 3: // textarea
            $flag = false;
            if( isset($defn['attribs']) && !empty($defn['attribs']) ) {
                $attribs = unserialize($defn['attribs']);
                if( is_array($attribs) && isset($attribs['wysiwyg']) ) $flag = $attribs['wysiwyg'];
            }
            $onerow->wysiwyg = $flag;
            break;

        case 4: // dropdown
            $opts = $this->GetSelectOptions($defn['name']);
            $onerow->options = array_flip($opts);
            break;

        case 5: // multiselect
            $opts = $this->GetSelectOptions($defn['name']);
            $onerow->options = array_flip($opts);
            $onerow->selected = explode(',',$val);
            break;

        case 6: // image
            $destDir1 = $gCms->config['uploads_path'].'/'.$this->get_settings()->image_destination_path.'/';
            $destDir2 = $gCms->config['uploads_url'].'/'.$this->get_settings()->image_destination_path.'/';
            $file1 = $destDir1.$val;
            $file2 = $destDir2.$val;
            if( is_readable( $file1 ) && is_file($file1) ) {
                $onerow->image_url = $file2;
                $onerow->image = '<img src="'.$file2.'" alt="'.$val.'"/>';
                if( !$onerow->required ) {
                    $onerow->prompt2 = $this->Lang('prompt_clear');
                    $onerow->input_name2 = $onerow->input_name . '_clear';
                }
            }
            break;

        case '7': // radio group
            $opts = $this->GetSelectOptions($defn['name']);
            $onerow->options = array_flip($opts);
            break;

        case '8': // date
            $onerow->start_year = $defn['extra']['startyear'] ?? '-5';
            $onerow->end_year = $defn['extra']['endyear'] ?? '+10';
            break;
        }
        $rowarray[$prop['name']] = $onerow;
    } // foreach

    // fill in the variables for the template
    $tpl = $this->CreateSmartyTemplate($thetemplate);
    $tpl->assign('controls', $rowarray);
    $tpl->assign('error', $error);
    $tpl->assign('user_info', $user);
    $tpl->assign('final_message', $final_message);
    $tpl->display();
}
catch( \Exception $e ) {
    cge_utils::log_exception($e);
    echo $this->DisplayErrorMessage($e->GetMessage());
}

// EOF
