<?php
namespace CGFEURegister;
use CMSMS\HookManager;
use cge_param;
if( !isset($gCms) ) exit;

$final_message = $error = $logged_in = $user = $feu_uid = null;
try {
    HookManager::do_hook('CGFEURegister::PreRender' );
    $error = $final_message = $user = null;
    $feu = $this->feu();
    $regManager = $this->regManager();
    $user_id = cge_param::get_int($params,'uid');
    $code_str = cge_param::get_string($params,'code');

    $user = $regManager->load_user_by_id($user_id);
    if( !$user ) throw new \LogicException('Could not find registering user with id '.$user_id);
    $feu_uid = $this->reg_handler()->push_user_live($user_id, $code_str);
    if( $this->settings()->login_after_verify ) {
	$this->feu()->SetUserLoggedin($feu_uid);
	$logged_in = true;
    }

    $final_message = $this->Lang('msg_after_verify');
}
catch( \Exception $e ) {
    // display error message
    $error = $e->GetMessage();
}

$tpl = $this->CreateSmartyTemplate(cge_param::get_string($params,'afterverifytemplate','after_verify.tpl'));
$tpl->assign('error', $error);
$tpl->assign('final_message', $final_message);
$tpl->assign('logged_in', $logged_in);
$tpl->assign('feu_uid', $feu_uid);
$tpl->display();
