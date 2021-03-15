<?php
namespace FrontEndUsers;
use CMSMS\HookManager;
use cge_param;
use cge_utils;

if( !isset($gCms) ) exit;
if( !$this->have_users_perm() ) return;

$user_id = $user = null;
try {
    $this->SetCurrentTab('users');
    $user = $this->retrieve_user_edit_assistant();

    if( isset($params['cancel']) ) {
        // clear anything in the session, but don't need the data.
        $this->SetMessage($this->Lang('msg_cancelled'));
        $this->RedirectToTab();
    }
    if( !$user ) throw new \LogicException('Could not restore user edit info from session');

    $user_id = $user->id;
    if( isset($params['back']) ) {
        $this->store_user_edit_assistant($user);
        $this->Redirect($id,'admin_edituser',$returnid, [ 'user_id' => $user_id ] );
    }

    $alldefns = $this->GetPropertyDefns();
    $fields = [];
    $properties = $this->GetMultiGroupPropertyRelations($user->groups);
    if( !count($properties) ) {
        // there are no properties to think of.
        // simulate submission.
        $params['submit'] = 1;
    } else {
        foreach( $properties as $prop ) {
            $prop_name = $prop['name'];
            if( !isset($alldefns[$prop_name]) ) throw new \LogicException('Definition for property '.$prop_name.' not found');
            $fields[$prop_name] = new property_editor_defn($alldefns[$prop_name],$prop,$user,$this->get_settings());
        }
    }

    if( isset($params['submit']) ) {
        /* handle submission */
        try {
            // note, we use the set value method on the field... it will actually modify the user
            // and set the data.
            foreach( $fields as $prop_name => $field ) {
                $key = 'prop_'.$prop_name;
                $key2 = 'propdel_'.$prop_name;
                $val = cge_utils::get_param($params,$key);
                if( $field->type == 8 ) {
                    // date
                    $val = cge_param::get_separated_date($params,$key);
                }
                else if( $field->type == 6 ) {
                    // image
                    if( isset($params[$key2]) ) $field->clear_value();
                    $val = $id.$key;
                }
                $field->set_value($val);
            }

            // pass 2 .. validate the input (required fields, upload types and so-on)
            foreach( $fields as $prop_name => $field ) {
                $field->validate($user->id);
            }

            // pass 2.1 ... ensure that if must_validate is on, that we have an email address
            // for this user.
            if( $user->must_validate && !$user->can_validate() ) {
                throw new \RuntimeException($this->Lang('error_validate_insufficientinfo2'));
            }

            $is_add = ($user->id < 1) ? TRUE : FALSE;
            $uid = $this->save_user_edit($user,$fields);

            // pass 3 .. do post proocessing (move files to final location etc).
            foreach( $fields as $prop_name => $field ) {
                $field->postprocess($user);
            }

            // all done... just gotta do some notifications and events.
            $evt_parms = [ 'name' => $user->username, 'id' => $uid ];
            if( $is_add ) {
                HookManager::do_hook('FrontEndUsers::OnCreateUser', $evt_parms );
                $this->SetMessage($this->Lang('msg_useradded'));
                audit('',$this->GetName(),'Added user '.$user->username);
            } else {
                HookManager::do_hook('FrontEndUsers::OnUpdateUser', $evt_parms );
                $this->SetMessage($this->Lang('msg_usermodified'));
                audit($user->id,$this->GetName(),'Modified user '.$user->username);
            }

            // done
            $this->RedirectToTab();
        }
        catch( \Exception $e ) {
            echo $this->ShowErrors($e->GetMessage());
        }
    }

    $tpl = $this->CreateSmartyTemplate('admin_edituser2.tpl');
    $tpl->assign('required_field_color', $this->get_settings()->required_field_color);
    $tpl->assign('hidden_field_color',$this->get_settings()->hidden_field_color);
    $tpl->assign('required_field_marker', $this->get_settings()->required_field_marker);
    $tpl->assign('hidden_field_marker',$this->get_settings()->hidden_field_marker);
    $tpl->assign('fields',$fields);
    $tpl->assign('user',$user);
    $tpl->display();
    $this->store_user_edit_assistant($user);
}
catch( \LogicException $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToTab();
}
catch( \Exception $e ) {
    if( $user ) $this->store_user_edit_assistant($user);
    $this->SetError($e->GetMessage());
    $this->Redirect($id,'admin_edituser',$returnid, [ 'user_id' => $user_id ] );
}
