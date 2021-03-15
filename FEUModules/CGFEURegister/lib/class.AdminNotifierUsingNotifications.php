<?php
namespace CGFEURegister;
use notification_message; // CGExtensions
use cge_userops;
use CGFEURegister;
use CMSModule;

class AdminNotifierUsingNotifications implements AdminNotifier
{
    private $mod;
    private $settings;
    private $notifier;

    public function __construct(CGFEURegister $mod, Settings $settings, CMSModule $notifier)
    {
        if( !method_exists($notifier,'send_message') ) throw new \InvalidArgumentException('Invalid notifier passed to '.__METHOD__);
        $this->mod = $mod;
        $this->settings = $settings;
        $this->notifier = $notifier;
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
        $proc = $this->mod->create_new_mailprocessor($eml);

        // create and send a notification message
        $msg = new notification_message;
        $msg->to_group = cge_userops::get_groupid($gname) * -1;
        $msg->subject = $proc->get_email_subject($eml);
        $msg->body = $proc->get_email_body($eml);
        $msg->html = true;
        $this->notifier->send_message($msg);
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
        $proc = $this->mod->create_new_mailprocessor($eml);

        // create and send a notification message
        $msg = new notification_message;
        $msg->to_group = cge_userops::get_groupid($gname) * -1;
        $msg->subject = $proc->get_email_subject();
        $msg->body = $proc->get_email_body();
        $msg->html = true;
        $this->notifier->send_message($msg);
    }
} // class
