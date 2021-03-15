<?php
namespace CGFEURegister;

class UsernameFilterDecorator
{
    public function validate_registration(RegFieldSet $fields, User $user)
    {
        // todo: match username/emails
        // on failure, do a hook and then throw an exception
        return $this->parent->validate_registration($fields, $user);
    }

} // class