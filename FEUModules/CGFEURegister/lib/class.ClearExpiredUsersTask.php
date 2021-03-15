<?php
namespace CGFEURegister;
use CGFEURegister;
use cms_utils;

include_once(__DIR__.'/interface.TaskInterface.php' ); // gross.
class ClearExpiredUsersTask implements DailyTask
{
    const LASTRUN_PREF = 'ClearExpiredUsersTask_lastrun';

    private $mod;
    private $regmgr;
    private $settings;

    public function __construct(CGFEURegister $mod, RegistrationManagerDecorator $regmgr, Settings $settings)
    {
        $this->mod = $mod;
        $this->regmgr = $regmgr;
        $this->settings = $settings;
    }

    public function daily()
    {
        if( ($user_expire_hours = $this->settings->user_expire_hours) < 1 ) return;
        $now = time();
        $lastrun = (int) $this->mod->GetPreference(self::LASTRUN_PREF);
        $this->mod->SetPreference(self::LASTRUN_PREF, $now);

        $filter = $this->regmgr->create_user_filter( ['expired'=>true ] );
        $users = $this->regmgr->load_users_by_filter($filter);
        foreach( $users as $user ) {
            $this->regmgr->delete_user_full($user);
            audit($user->id,$this->mod->GetName(),'Deleted expired user '.$user->username);
        }
    }
} // class