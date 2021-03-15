<?php
namespace CGFEURegister;
use cge_param;

$filter_fields = function(RegFieldSet $set) : RegFieldSet {
    $list = null;
    foreach( $set as $one ) {
        if( $one->type !== -100 ) $list[$one->name] = $one;
    }
    return new RegFieldSet($list);
};

try {
    $uid = cge_param::get_int($params, 'uid');
    $user = $this->regManager()->load_user_by_id($uid);
    if( !$user ) throw new \LogicException('User not found');
    $fields = $this->regManager()->get_registration_fields($user->gid);
    $fields = $filter_fields($fields);

    if( !empty($_POST) ) {
        if( cge_param::exists($_POST, 'cancel') ) {
            $this->RedirectToAdminTab();
        }
        elseif( cge_param::exists($_POST, 'deleteuser') ) {
            $this->regManager()->delete_user_full($user);
            audit($user->id,$this->GetName(),'User '.$user->username.' deleted');

            $this->SetMessage($this->Lang('msg_user_deleted'));
            $this->RedirectToAdminTab();
        }
        elseif( cge_param::exists($_POST, 'pushuser') ) {
            $feu_uid = $this->reg_handler()->force_push_user_live($user);
            audit($user->id,$this->GetName(),'User '.$user->username.' pushed to FEU with uid '.$feu_uid);
            $this->RedirectToAdminTab();
        }
        elseif( cge_param::exists($_POST, 'newcode') ) {
            $code = $this->regManager()->create_registration_code($user);
            $this->regManager()->save_verification_code($code);
            $this->reg_sender()->execute($fields, $user, $code);
            audit($user->id,$this->GetName(),'Sent a new code to '.$user->username);

            $this->SetMessage($this->Lang('msg_user_newcode'));
            $this->RedirectToAdminTab();
        }
        elseif( cge_param::exists($_POST, 'submit') ) {
            $user = $this->regManager()->fill_from_data($fields, $user, $_POST);
            $this->regVerifier()->validate_pure_registration($fields, $user);
            $this->regManager()->save_user($user);
            audit($user->id,$this->GetName(),'User '.$user->username.' edited');

            $this->SetMessage($this->Lang('msg_user_saved'));
            $this->RedirectToAdminTab();
        }
    }
    // todo:pagination and filtering
    $tpl = $this->CreateSmartyTemplate('admin_edit_user.tpl');
    $tpl->assign('user', $user);
    $tpl->assign('fields', $fields);
    $tpl->display();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToAdminTab();
}
