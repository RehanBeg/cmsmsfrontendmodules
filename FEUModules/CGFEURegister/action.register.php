<?php
namespace CGFEURegister;
use CMSMS\HookManager;
use cge_param;
use cge_utils;
if( !isset($gCms) ) exit;

class NoUserDataException extends \RuntimeException {}

try {
    HookManager::do_hook('CGFEURegister::PreRender');

    $error = $final_message = $user = $captcha = null;
    $feu = $this->feu();
    $regManager = $this->regManager();
    if( $feu->LoggedInID() ) return;  // already logged in
    $thetemplate = cge_param::get_string($params, 'regtemplate', 'register.tpl');
    $inline = cge_param::get_bool($params, 'inline');
    $nocaptcha = cge_param::get_int($params, 'nocaptcha');
    if( !$nocaptcha ) $captcha = $this->GetModuleInstance('Captcha');

    // group is a required parameter.
    $group = cge_param::get_string($params, 'group');
    if( !$group ) throw new \InvalidArgumentException('No group parameter passed to '.$this->GetName());
    $gid = $feu->GetGroupID($group);
    if( $gid < 1 ) throw new \CmsError404Exception('Invalid group name passed to '.$this->GetName());
    $groupinfo = $feu->GetGroupInfo($gid);
    if( !$groupinfo ) throw new \CmsError404Exception('Could not find FEU group '.$group);

    $fields = $regManager->get_registration_fields($gid);
    if( !count($fields) ) throw new \LogicException('No properties found for the selected registration group');
    $user = $regManager->create_new_user($fields, null, $gid);

    if( ($key = cge_param::get_string($params, 'after')) ) {
        try {
            $tmp = $this->session_get($key);
            $this->session_clear($key);
            if( !$tmp ) throw new NoUserDataException('Could not retrieve user data');
            $data = json_decode($tmp,TRUE);
            $user = $regManager->create_new_user($fields, $data);
            $final_message = $this->reg_sender()->get_final_message($fields, $user);
        }
        catch( NoUserDataException $e ) {
            $error = $e->GetMessage();
        }
        catch( \Exception $e ) {
            $error = $e->GetMessage();
            cge_utils::log_exception($e);
        }
    }
    else if( cge_param::exists($_POST, $id.'submit') ) {
        try {
            if( !cge_utils::valid_form_csrf() ) throw new \RuntimeException( $this->Lang('err_security') );
            $user = $regManager->fill_from_data($fields, $user, $_POST);

            // check the captcha
            if( !$nocaptcha && $captcha && !$captcha->CheckCaptcha(cge_param::get_string($params,'captcha_text')) ) {
                throw new \RuntimeException($this->Lang('error_captchamismatch'));
            }

            // save this thing
            $user = $this->reg_handler()->register_user($user);

            // redirect after post.
            $guid = cge_utils::create_guid();
            $this->session_put($guid, json_encode($user));
            $this->Redirect($id,'register', $returnid, ['after'=>$guid, 'group'=>$group], $inline);
        }
        catch( \RuntimeException $e ) {
            $error = $e->GetMessage();
        }
        catch( \Exception $e ) {
            // gonna delete the user if we can
            $error = $e->GetMessage();
            if( $user->id ) {
                $regManager->delete_user_full($user);
            }
            else {
                $user = $regManager->load_user_by_username($user->username);
                $regManager->delete_user_full($user);
            }
        }
    }

    $tpl = $this->CreateSmartyTemplate($thetemplate);
    $tpl->assign('group', $groupinfo);
    $tpl->assign('properties', $fields);
    $tpl->assign('error', $error);
    $tpl->assign('final_message', $final_message);
    $tpl->assign('user', $user);
    $tpl->assign('inline', $inline);
    $tpl->assign('captcha', (is_object($captcha)) ? $captcha->getCaptcha() : null);
    $tpl->assign('captcha_input_name', (is_object($captcha) && $captcha->NeedsInputField()) ? $id.'captcha_text' : null );
    $tpl->display();
}
catch( \Exception $e ) {
    throw $e;
}
