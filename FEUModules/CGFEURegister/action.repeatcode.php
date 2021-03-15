<?php
namespace CGFEURegister;
use CMSMS\HookManager;
use cge_param;
use cge_utils;
if( !isset($gCms) ) exit;

try {
    if( $this->settings()->disable_repeatcode) throw new \CmsError403Exception('Permission denied');
    HookManager::do_hook('CGFEURegister::PreRender');
    $username = $error = $final_message = $captcha = null;
    $regManager = $this->regManager();

    $thetemplate = cge_param::get_string($params, 'repeatcodetemplate', 'repeatcode.tpl');
    $inline = cge_param::get_bool($params, 'inline');
    $nocaptcha = cge_param::get_int($params, 'nocaptcha');
    if( !$nocaptcha ) $captcha = $this->GetModuleInstance('Captcha');
    $username_type = ($this->feu()->GetUsernameFieldType() == 2) ? 'email' : 'text';

    if( ($key = cge_param::get_string($params, 'after')) ) {
        try {
            $tmp = $this->session_get($key);
            $this->session_clear($key);
            if( !$tmp ) throw new \LogicException('Could not retrieve user data');
            $data = json_decode($tmp,TRUE);
            if( !isset($data['id']) || !isset($data['created']) || !isset($data['gid']) ) {
                throw new \LogicException('Invalid user data retrieved');
            }
            $gid = cge_param::get_int($data,'gid');
            $fields = $regManager->get_registration_fields($gid);
            $user = $regManager->create_new_user($fields, $data);
            // fields may be empty if group is removed with while user is registering.
            if( !$fields ) throw new \LogicException('Could not get fields for user with gid '.$user->gid);
            $final_message = $this->reg_sender()->get_repeatcode_finalmessage($fields, $user);
        }
        catch( \Exception $e ) {
            $error = $e->GetMessage();
            cge_utils::log_exception();
        }
    }
    else if( cge_param::exists($_POST,$id.'username') ) {
        try {
            if( !cge_utils::valid_form_csrf() ) throw new \RuntimeException( $this->Lang('err_security') );

            $username = cms_html_entity_decode(cge_param::get_string($params, 'username'));

            // check the captcha
            if( $captcha && !$captcha->CheckCaptcha(cge_param::get_string($params, 'captcha_text')) ) {
                throw new \RuntimeException($this->Lang('err_captchamismatch'));
            }

            // load the user given the username and make sure it is not too old
            $user = $regManager->load_user_by_username($username);
            if( !$user ) throw new \RuntimeException( $this->Lang('err_user_notfound') );
            if( ($hrs = $this->settings()->user_expire_hours) > 0 && $user->created < time() - $hrs * 3600 ) {
                throw new \RuntimeException( $this->Lang('err_user_notfound') );
            }

            $fields = $regManager->get_registration_fields($user->gid);
            // fields may be empty if group is removed with while user is registering.
            if( !$fields ) throw new \LogicException('Could not get fields for user with gid '.$user->gid);

            // generate another registration code
            $code = $regManager->create_registration_code($user);
            $regManager->save_verification_code($code);

            // call the registration processor
            $this->reg_sender()->execute_repeatcode($fields, $user, $code);
            HookManager::do_hook('CGFEURegister::AfterRepeatCode', ['fields'=>$fields, 'user'=>$user]);

            // redirect after post
            $guid = cge_utils::create_guid();
            $this->session_put($guid, json_encode($user));
            $this->Redirect($id,'repeatcode', $returnid, ['after'=>$guid], $inline);
        }
        catch( \RuntimeException $e ) {
            $error = $e->GetMessage();
        }
    }

    $tpl = $this->CreateSmartyTemplate($thetemplate);
    $tpl->assign('inline', $inline);
    $tpl->assign('username', $username);
    $tpl->assign('final_message',$final_message);
    $tpl->assign('error', $error);
    $tpl->assign('captcha', (is_object($captcha)) ? $captcha->getCaptcha() : null);
    $tpl->assign('captcha_input_name', (is_object($captcha) && $captcha->NeedsInputField()) ? $id.'captcha_text' : null );
    $tpl->assign('input_type', $username_type);
    $tpl->display();
}
catch( \Exception $e ) {
    cge_utils::log_exception($e);
    throw $e;
}
