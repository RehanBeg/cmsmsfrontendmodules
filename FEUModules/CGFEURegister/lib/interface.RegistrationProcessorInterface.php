<?php
namespace CGFEURegister;

interface RegistrationProcessorInterface
{
    public function execute(RegFieldSet $set, User $user, VerificationData $data);
    public function get_final_message(RegFieldSet $set, User $user) : string;

    public function execute_repeatcode(RegFieldSet $set, User $user, VerificationData $data);
    public function get_repeatcode_finalmessage(RegFieldSet $set, User $user) : string;
} // interface