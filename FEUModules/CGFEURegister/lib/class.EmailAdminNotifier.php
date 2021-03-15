<?php
namespace CGFEURegister;
use CGFEURegister;

class EmailAdminNotifier implements AdminNotifier
{
    private $mod;
    private $settings;

    public function __construct(CGFEURegister $mod, Settings $settings)
    {
        $this->mod = $mod;
        $this->settings = $settings;
    }

    public function notify_user_registered(RegFieldSet $fields, User $user)
    {
        if( !($gname = $this->settings->onregister_notify_admingroup) ) return;

	debug_to_log(__METHOD__);
        $eml = $this->mod->get_email_storage()->load('admin_notify_userregistered.eml');
        if( !$eml ) throw new \LogicException('Could not find the admin_notify_userregistered.eml email template');
        $eml = $eml->add_data('user', $user)
            ->add_data('fields', $fields)
            ->add_admin_group($gname);
        $this->mod->create_new_mailprocessor($eml)->send();
    }

    public function notify_user_pushed(int $feu_uid, RegFieldSet $fields, User $user)
    {
        if( !($gname = $this->settings->onpush_notify_admingroup) ) return;
        if( $feu_uid < 1 ) throw new \LogicException('invalid feu_uid passed to '.__METHOD__);

	debug_to_log(__METHOD__);
        $eml = $this->mod->get_email_storage()->load('admin_notify_userpushed.eml');
        if( !$eml ) throw new \LogicException('Could not find the admin_notify_userpushed.eml email template');
        $eml = $eml->add_data('user', $user)
            ->add_data('fields', $fields)
            ->add_data('feu_uid', $feu_uid)
            ->add_admin_group($gname);
        $this->mod->create_new_mailprocessor($eml)->send();
    }
} // class
