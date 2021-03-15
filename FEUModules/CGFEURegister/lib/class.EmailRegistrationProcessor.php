<?php
namespace CGFEURegister;
use CGFEURegister;
use FrontEndUsers;

class EmailRegistrationProcessor implements RegistrationProcessorInterface
{
    private $mod;
    private $settings;

    public function __construct(CGFEURegister $mod, Settings $settings)
    {
        $this->mod = $mod;
        $this->settings = $settings;
    }

    protected function get_email(RegFieldSet $set, User $user)
    {
        // get an email address
        $email = null;
        if( $this->settings->username_is_email ) {
            return $user->get($user::USERNAME_FIELD);
        } else {
            foreach( $set as $field ) {
                if( $field->type == FrontendUsers::PROPTYPE_EMAIL ) {
                    $propname = $field->name;
                    $email = $user->get($propname);
                    if( $email ) return $email;
                }
            }
        }
    }

    public function execute(RegFieldSet $set, User $user, VerificationData $data)
    {
        try {
            $email = $this->get_email($set, $user);
            if( !$email ) throw new \LogicException('Could not find a valid email address to send to');

            $eml = $this->mod->get_email_storage()->load('on_register.eml');
            if( !$eml ) throw new \LogicException('Could not find the on_register.eml email template');
            $eml = $eml->add_address($email)
                ->add_data('fields', $set)
                ->add_data('user', $user)
                ->add_data('data', $data);
            $this->mod->create_new_mailprocessor( $eml )->send();
            audit($user->id,$this->mod->GetName(),'Sent registration email to '.$user->username);
        }
        catch( \Exception $e ) {
            throw $e;
        }
    }

    public function get_final_message(RegFieldSet $set, User $user) : string
    {
        $email = $this->get_email($set, $user);
        if( !$email ) throw new \LogicException('Could not find a valid email address to send to');

        $tpl = $this->mod->CreateSmartyTemplate('post_register_message.tpl');
        $tpl->assign('email',$email);
        $tpl->assign('user',$user);
        return $tpl->fetch();
    }

    public function execute_repeatcode(RegFieldSet $set, User $user, VerificationData $data)
    {
        try {
            $email = $this->get_email($set, $user);
            if( !$email ) throw new \LogicException('Could not find a valid email address to send to');

            $storage = $this->mod->get_email_storage();
            $eml = $storage->load('on_repeatcode.eml');
            if( !$eml ) throw new \LogicException('Could not find the on_repeatcode.eml email template');
            $eml = $eml->add_address($email)
                ->add_data('fields', $set)
                ->add_data('user', $user)
                ->add_data('data', $data);
            $this->mod->create_new_mailprocessor( $eml )->send();
            audit($user->id,$this->mod->GetName(),'Sent repeatcode email to '.$user->username);
        }
        catch( \Exception $e ) {
            throw $e;
        }
    }

    public function get_repeatcode_finalmessage(RegFieldSet $set, User $user) : string
    {
        return $this->mod->Lang('post_repeatcode_message');
    }
} // class