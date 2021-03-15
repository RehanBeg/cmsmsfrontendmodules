<?php
namespace CGFEURegister;

interface AdminNotifier
{
    public function notify_user_registered(RegFieldSet $set, User $user);
    public function notify_user_pushed(int $feu_uid, RegFieldSet $set, User $user);
} // interface