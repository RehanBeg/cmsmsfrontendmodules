<?php
declare(strict_types=1);
namespace FrontEndUsers;

interface UserAuthenticator
{
    // returns either an authtoken or null
    public function get_login_token();

    public function set_login_token(AuthToken $token);

    // return a userid for the currerntly authenticated user
    // or a value less than 1
    public function get_current_userid(UserManipulator $manipulator) : int;

    // deauthenticate the current user;
    public function remove_authentication(UserManipulator $manipulator);

} // class
