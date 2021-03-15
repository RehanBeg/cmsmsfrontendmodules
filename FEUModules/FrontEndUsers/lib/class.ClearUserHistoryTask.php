<?php
declare(strict_types=1);
namespace FrontEndUsers;
use CMSMS\HookManager;
use cms_utils;

class ClearUserHistoryTask implements \CmsRegularTask
{
    private $clearhistory_age;

    public function __construct(int $clearhistory_age)
    {
        $this->clearhistory_age = $clearhistory_age;
    }

    public function get_name()
    {
        return get_class();
    }

    public function get_description() {}

    public function test( $time = '')
    {
        if( !$time ) $time = time();
        $mod = cms_utils::get_module( MOD_FRONTENDUSERS );
        $tmp = $this->clearhistory_age;
        if( $tmp < 1 ) return;
        $lastrun = (int) $mod->GetPreference('clearhistory_lastrun',0);
        if( $lastrun > time() - 24 * 3600 ) return;

        return TRUE;
    }

    public function execute( $time = '' )
    {
        if( !$time ) $time = time();
        $mod = cms_utils::get_module( MOD_FRONTENDUSERS );
        $max_age_days = $this->clearhistory_age;
        // delete everything from the history that is older than $max_age_days

        $older_than = time() - $max_age_days * 24 * 3600;
        HookManager::do_hook( 'FrontEndUsers::ClearUserHistory', $older_than );
        $sql = 'DELETE FROM '.cms_db_prefix().'module_feusers_history WHERE refdate < ?';
        $db = $mod->GetDb();
        $db->Execute( $sql, $db->DbTimeStamp( $older_than ) );

        audit('','FrontEndUsers','Removed history entries older than '.strftime( '%x %X', $older_than ));
        return TRUE;
    }

    public function on_success($time = '')
    {
        if( !$time ) $time = time();
        $feu = cms_utils::get_module( MOD_FRONTENDUSERS );
        $feu->SetPreference('clearhistory_lastrun',$time);
    }

    public function on_failure($time = '')
    {
        if( !$time ) $time = time();
    }

} // class
