<?php
namespace CGFEURegister;

interface RegistrationHandlerInterface
{
    public function register_user(User $user) : User;
    public function force_push_user_live(User $user) : int;
    public function push_user_live(int $user_id, string $code_str) : int;
} // class