<?php
namespace CGFEURegister;

class SimpleRegistrationHandler implements RegistrationHandlerInterface
{
    private$rmgr;
    private $processor;
    private $verifier;

    public function __construct(RegistrationManager $rmgr,
                                RegistrationProcessorInterface $processor,
                                RegistrationVerifierInterface $verifier)
    {
        $this->rmgr = $rmgr;
        $this->processor = $processor;
        $this->verifier = $verifier;
    }

    protected function registration_manager() : RegistrationManager
    {
        return $this->rmgr;
    }

    public function register_user(User $user) : User
    {
        $fields = $this->rmgr->get_registration_fields($user->gid);
        $this->verifier->validate_registration($fields, $user);

        $user = $this->rmgr->save_user($user);
        $code = $this->rmgr->create_registration_code($user);
        $this->rmgr->save_verification_code($code);
        $this->processor->execute($fields, $user, $code);
        return $user;
    }

    public function force_push_user_live(User $user) : int
    {
        $fields = $this->rmgr->get_registration_fields($user->gid);
        $feu_uid = $this->rmgr->push_user_live($fields, $user);
        $this->rmgr->delete_user_full($user);
        return $feu_uid;
    }

    public function push_user_live(int $user_id, string $code_str) : int
    {
        $user = $this->rmgr->load_user_by_id($user_id);
        $code = $this->rmgr->load_verification_code($code_str);

        // check if the user is valid if the code is valid
        if( !$user || !$code ) throw new \RuntimeException($this->Lang('err_cannotverify'));
        if( $user->gid < 1 ) throw new \RuntimeException($this->Lang('err_cannotverify').' 2');
        if( $user->id != $code->uid || $code->expires < time() ) throw new \RuntimeException($this->Lang('err_cannotverify').' 3');
        if( $this->rmgr->is_user_expired($user) ) throw new \RuntimeException($this->Lang('err_cannotverify').' 4');

        // forcepush live
        return $this->force_push_user_live($user);
    }

} // class
