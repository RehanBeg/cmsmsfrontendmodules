<?php
namespace CGFEURegister;

interface RegistrationVerifierInterface
{
    public function validate_pure_registration(RegFieldSet $fields, User $user);
    public function validate_registration(RegFieldSet $set, User $user);
} // interface