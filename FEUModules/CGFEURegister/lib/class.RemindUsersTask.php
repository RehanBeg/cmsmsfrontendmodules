<?php
namespace CGFEURegister;
use CGFEURegister;
use cms_utils;

include_once(__DIR__.'/interface.TaskInterface.php' ); // gross.
class RemindUsersTask implements HourlyTask
{
    const LASTRUN_PREF = 'RemindUsersTask_lastrun';

    private $mod;
    private $regmgr;
    private $settings;

    public function __construct(CGFEURegister $mod, RegistrationManagerDecorator $regmgr, Settings $settings)
    {
        $this->mod = $mod;
        $this->regmgr = $regmgr;
        $this->settings = $settings;
    }

    protected function get_email(RegFieldSet $set, User $user)
    {
        // this utility method should prolly be in the RegistrationManager
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

    public function send_reminder_email(User $user)
    {
        $fields = $this->regmgr->get_registration_fields($user->gid);
        $email = $this->get_email($fields, $user);
        if( !$email ) throw new \LogicException('Could not find a valid email address to send to');

        $destpage = $this->mod->cms->GetContentOperations()->GetDefaultContent();
        if( $this->settings->repeatcode_page ) {
            $destpage = $this->mod->resolve_alias_or_id( $this->settings->repeatcode_page, $destpage );
        }

        $eml = $this->mod->get_email_storage()->load('on_remind.eml');
        if( !$eml ) throw new \LogicException('Could not find the on_register.eml email template');
        $eml = $eml->add_address($email)
            ->add_data('fields', $fields)
            ->add_data('repeatcode_page', $destpage)
            ->add_data('user', $user);
        $this->mod->create_new_mailprocessor( $eml )->send();
    }

    // probably should be a daily task
    public function hourly()
    {
        // get the last run
        debug_to_log(__METHOD__);

        if( ($remind_hours_interval = $this->settings->remindusers_after_hours) < 1 ) return;
        $now = time();
        $lastrun = (int) $this->mod->GetPreference(self::LASTRUN_PREF);
        $this->mod->SetPreference(self::LASTRUN_PREF, $now);

        $max_created = max($lastrun, $now - $remind_hours_interval);
        $filter = $this->regmgr->create_user_filter( ['created_before'=>$max_created ] );
        $users = $this->regmgr->load_users_by_filter($filter);
        foreach( $users as $user ) {
            if( ($hrs = $this->settings->user_expire_hours) > 0 && $user->created >= $now - $hrs * 3600 ) {
                // not expired
                $this->send_reminder_email($user);
                audit($user->id,$this->mod->GetName(),'Sent reminder email to '.$user->username);
            }
        }
    }
} // class