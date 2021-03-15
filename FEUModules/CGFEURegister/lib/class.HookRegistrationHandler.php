<?php
namespace CGFEURegister;
use CMSMS\HookManager;

class HookRegistrationHandler extends SimpleRegistrationHandler
{
    public function register_user(User $user) : User
    {
        HookManager::do_hook('CGFEURegister::BeforeRegister', ['user'=>$user]);
        $user = parent::register_user($user);
        HookManager::do_hook('CGFEURegister::AfterRegister', ['user'=>$user]);
        return $user;
    }

    public function push_user_live(int $user_id, string $code_str) : int
    {
        $user = $this->registration_manager()->load_user_by_id($user_id);
        $fields = $this->registration_manager()->get_registration_fields($user->gid);
        $feu_uid = parent::push_user_live($user_id, $code_str);
        HookManager::do_hook('CGFEURegister::AfterUserPushed', ['user'=>$user, 'fields'=>$fields, 'feu_uid'=>$feu_uid]);
        return $feu_uid;
    }

} // class
