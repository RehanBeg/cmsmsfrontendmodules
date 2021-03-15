<?php
use CGFEURegister\RegistrationManager;
use CGFEURegister\MemoryCacheRegistrationManager;
use CGFEURegister\RegistrationVerifierInterface;
use CGFEURegister\RegistrationProcessorInterface;
use CGFEURegister\NormalRegistrationVerifier;
use CGFEURegister\BlacklistRegistrationVerifier;
use CGFEURegister\Settings;
use CGFEURegister\EmailRegistrationProcessor;
use CGFEURegister\RegistrationHandlerInterface;
use CGFEURegister\HookRegistrationHandler;
use CGFEURegister\AdminNotifier;
use CGFEURegister\EmailAdminNotifier;
use CGFEURegister\AdminNotifierUsingNotifications;
use CGFEURegister\HourlyHookTask;
use CGFEURegister\TaskManager;
use CGFEURegister\RemindUsersTask;
use CGFEURegister\ClearExpiredUsersTask;
use CMSMS\HookManager;

final class CGFEURegister extends CGExtensions
{
    public function GetVersion() { return '1.0.4'; }
    public function MinimumCMSVersion() { return '2.2.10'; }
    public function GetDependencies() { return [ 'CGExtensions'=>'1.64.2', 'FrontEndUsers'=>'2.99' ]; }
    public function IsPluginModule() { return TRUE; }
    public function HasAdmin() { return TRUE; }
    public function GetAdminSection () { return 'usersgroups'; }
    public function GetFriendlyName() { return $this->Lang('friendlyname'); }

    public function SetParameters()
    {
        parent::SetParameters();
        HookManager::add_hook('CGFEURegister::__InternalHourlyTask', [ $this, 'hook_hourly'] );
    }

    public function InitializeFrontend()
    {
        parent::InitializeFrontend();
        $this->RegisterModulePlugin();
        $this->RegisterRoute('/cgfeur\/verify\/(?P<returnid>[0-9]+)\/(?P<uid>[0-9]+)\/(?P<code>.*?)$/', ['action'=>'verify'] );

        HookManager::add_hook('CGFEURegister::AfterRegister', [ $this, 'hook_afterregister_emailadmin'] );
        HookManager::add_hook('CGFEURegister::AfterUserPushed', [ $this, 'hook_afterpushed_emailadmin'] );
    }

    public function get_pretty_url($id,$action,$returnid='',$params=array(),$inline=false)
    {
        if( $action != 'verify' ) return;
        if( !($code = cge_param::get_string($params,'code')) ) return;
        $uid = cge_param::get_int($params,'uid');
        if( $uid < 1 ) return;
        return "cgfeur/verify/$returnid/$uid/$code";
    }

    function HasCapability($capability,$params = array())
    {
        switch( $capability ) {
        case 'tasks':
            return true;
        }
        return false;
    }

    function get_tasks()
    {
        $out = null;
        $out[] = new HourlyHookTask();
        return $out;
    }

    ////////////////////////////////////////////

    protected function feu() : FrontEndUsers
    {
        static $_obj;
        if( !$_obj ) $_obj = $this->GetModuleInstance(MOD_FRONTENDUSERS);
        return $_obj;
    }

    protected function settings() : Settings
    {
        // a settings class
        static $_obj;
        if( !$_obj ) $_obj = new Settings($this->config);
        return $_obj;
    }

    protected function regManager() : RegistrationManager
    {
        // this is responsible for saving and retrieving users and verification codes to/from the database
        static $_obj;
        if( !$_obj ) {
            $_obj = new MemoryCacheRegistrationManager($this, $this->feu(), $this->get_extended_db(), $this->settings());
        }
        return $_obj;
    }

    protected function regVerifier() : RegistrationVerifierInterface
    {
        // todo: could have decorator here that sends hooks
        static $_obj;
        if( !$_obj ) {
            $_obj = new NormalRegistrationVerifier($this, $this->feu(), $this->get_extended_db());
            if( $this->cms->is_frontend_request() && $this->settings()->username_blacklist ) $_obj = new BlacklistRegistrationVerifier($_obj, $this->settings());
        }
        return $_obj;
    }

    protected function reg_sender() : RegistrationProcessorInterface
    {
        // this is used for sending the registration information to the user.
        static $_obj;
        if( !$_obj ) $_obj = new EmailRegistrationProcessor($this, $this->settings());
        return $_obj;
    }

    protected function admin_notifier() : AdminNotifier
    {
        // an object that knows how to notify admins
        static $_obj;
        if( !$_obj ) {
            $notifier = null;
            $list = $this->GetModulesWithCapability('notifications');
            if( !empty($list) && !$this->settings()->use_builtin_notifications ) {
                $mod_name = $list[0];
                if( $mod_name ) $notifier = $this->GetModuleInstance($mod_name);
                if( $notifier ) $_obj = new AdminNotifierUsingNotifications($this, $this->settings(), $notifier);
            }
            if( !$_obj ) $_obj = new EmailAdminNotifier($this, $this->settings());
        }
        return $_obj;
    }

    protected function reg_handler() : RegistrationHandlerInterface
    {
        // an aggregate that knows how to handle both user registration AND pushing live.
        static $_obj;
        if( !$_obj ) $_obj = new HookRegistrationHandler($this->regManager(), $this->reg_sender(), $this->regVerifier());
        return $_obj;
    }

    protected function task_manager() : TaskManager
    {
        // should be an abstract class or interface
        static $_obj;
        if( !$_obj ) {
            $_obj = new TaskManager($this->get_tasks());
            $_obj->register_task(new RemindUsersTask($this, $this->regManager(), $this->settings()));
            $_obj->register_task(new ClearExpiredUsersTask($this, $this->regManager(), $this->settings()));
        }
        return $_obj;
    }

    ////////////////////////////////////////////

    /**
     * @internal
     */
    public function hook_afterregister_emailadmin(array $params)
    {
        try {
            $group = $this->settings()->onregister_notify_admingroup;
            if( !$group ) return;

            $user = $params['user'];
            $fields = $this->regManager()->get_registration_fields($user->gid);
            $this->admin_notifier()->notify_user_registered($fields, $user);
        }
        catch( \CGExtensions\Email\Exception $e ) {
            debug_to_log(__METHOD__);
            cge_utils::log_exception($e);
        }
    }

    /**
     * @internal
     */
    public function hook_afterpushed_emailadmin(array $params)
    {
        try {
            $group = $this->settings()->onregister_notify_admingroup;
            if( !$group ) return;

            $this->admin_notifier()->notify_user_pushed($params['feu_uid'], $params['fields'], $params['user']);
        }
        catch( \CGExtensions\Email\Exception $e ) {
            debug_to_log(__METHOD__);
            cge_utils::log_exception($e);
        }
    }

    /**
     * @internal
     */
    public function hook_hourly()
    {
        debug_to_log(__METHOD__);

        // runs via pseudocron.
        // we want daily, hourly, and weekly stuff
        $now = time();
        $lr_hourly = $this->GetPreference('hourly_lastrun');
         if( $lr_hourly < $now - 3600 ) {
            $this->task_manager()->hourly();
            $this->SetPreference('hourly_lastrun', $now);
        }
        $lr_daily = $this->GetPreference('daily_lastrun');
        if( $lr_daily < $now - 3600 * 24 ) {
            debug_to_log('do daily tasks');
            $this->task_manager()->daily();
            $this->SetPreference('daily_lastrun', $now);
        }
        $lr_weekly = $this->GetPreference('weekly_lastrun');
        if( $lr_weekly = $now - 3600 * 24 * 7 ) {
            debug_to_log('do weekly tasks');
            $this->task_manager()->weekly();
            $this->SetPreference('weekly_lastrun', $now);
        }
        $lr_monthly = $this->GetPreference('monthly_lastrun');
        if( $lr_monthly = $now - 3600 * 24 * 30 ) {
            debug_to_log('do monthly tasks');
            $this->task_manager()->monthly();
            $this->SetPreference('monthly_lastrun', $now);
        }
    }

    ////////////////////////////////////////////

    public function users_table_name() { return CMS_DB_PREFIX.'mod_cgfr_users'; }
    public function codes_table_name() { return CMS_DB_PREFIX.'mod_cgfr_codes'; }

} // class
