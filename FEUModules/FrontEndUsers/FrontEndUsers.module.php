<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008-2016 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management of frontend
#  users, and their login process within a CMS Made Simple powered
#  website.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE

/**
 * This is the primary interface to FrontEndUsers
 *
 * @package FrontEndUsers
 */
declare(strict_types=1);
use FrontEndUsers\verification_assistant;
use FrontEndUsers\email_verify_assistant;
use FrontEndUsers\UserManipulatorInterface;
use FrontEndUsers\FrontEndUsersManipulator;
use FrontEndUsers\InternalCachingManipulator;
use FrontEndUsers\UserCacheManipulator;
use FrontEndUsers\FeuUserQueryDecorator;
use FrontEndUsers\CachedUserQueryDecorator;
use FrontEndUsers\HookSenderDecorator;
use FrontEndUsers\UserHistoryDecorator;
use FrontEndUsers\BuiltinUserAuthenticator; // for lack of a better name
use FrontEndUsers\userSet;
use FrontEndUsers\UserEditDecorator;
use FrontEndUsers\settings;
use FrontEndUsers\hook_handler;
use CMSMS\HookManager;

/**
 * This file defines the FrontEndUsers module class.
 *
 * @package FrontEndUsers
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2019 by Robert Campbell
 */

/**
 * The FrontEndUsers module, besides being a module to provide authorization services to the frontend of a CMSMS website also has a complete
 * and flexible API.
 *
 * This module provides it's api by acting as a UserManipulatorInterface
 *
 * @see FrontEndUsers\UserManipulator
 * @package FrontEndUsers
 */
final class FrontEndUsers extends CGExtensions
{
    /**
     * @ignore
     */
    const PERM_PROPS  = 'FEU Modify FrontendUserProps';
    /**
     * @ignore
     */
    const PERM_USERS  = 'FEU Modify Users';
    /**
     * @ignore
     */
    const PERM_GROUPS = 'FEU Modify Groups';

    /**
     * Constant to indentify a text property.
     */
    const FIELDTYPE_TEXT = 0;

    /**
     * Constant to indentify a checkbox property.
     */
    const FIELDTYPE_CHECKBOX = 1;

    /**
     * Constant to indentify an email property.
     */
    const FIELDTYPE_EMAIL = 2;

    /**
     * Constant to indentify a textarea property.
     */
    const FIELDTYPE_TEXTAREA = 3;

    /**
     * Constant to indentify a dropdown property.
     */
    const FIELDTYPE_DROPDOWN = 4;

    /**
     * Constant to indentify a multiselect property.
     */
    const FIELDTYPE_MULTISELECT = 5;

    /**
     * Constant to indentify an image property.
     */
    const FIELDTYPE_IMAGE = 6;

    /**
     * Constant to indentify a radio button group property.
     */
    const FIELDTYPE_RADIOBUTNS = 7;

    /**
     * Constant to indentify a date property.
     */
    const FIELDTYPE_DATE = 8;

    /**
     * Constant to indentify a data property.
     */
    const FIELDTYPE_DATA = 9;

    /**
     * Constant to indentify a telephone number property.
     */
    const FIELDTYPE_TEL = 10;

    /**
     * @ignore
     */
    private $verification_assistant = null;

    /**
     * Constructor
     *
     * @ignore
     */
    public function __construct()
    {
        parent::__construct();
        $this->AddImageDir('icons');
    }

    /**
     * @ignore
     * @internal
     */
    final public function GetFieldTypes() : array
    {
        return [ 'text' => self::FIELDTYPE_TEXT,
                 'checkbox' => self::FIELDTYPE_CHECKBOX,
                 'email' => self::FIELDTYPE_EMAIL,
                 'textarea' => self::FIELDTYPE_TEXTAREA,
                 'dropdown' => self::FIELDTYPE_DROPDOWN,
                 'multiselect' => self::FIELDTYPE_MULTISELECT,
                 'image' => self::FIELDTYPE_IMAGE,
                 'radiobuttons' => self::FIELDTYPE_RADIOBUTNS,
                 'date' => self::FIELDTYPE_DATE,
                 'data' => self::FIELDTYPE_DATA,
                 'tel' => self::FIELDTYPE_TEL,
            ];
    }

    /**
     * Get the User Manipulator Object
     * NOT FOR EXTERNAL USE
     *
     * @internal
     * @return object
     */
    public function GetManipulator() : UserManipulatorInterface
    {
        static $_obj;
        if( !$_obj ) {
            // these classes are used to extend functionality on the UserManipulator class (caching, querying, hooks, auditing etc)
            // todo: move cookie stuff into another decorator or manipulator.
            // todo: move expiry stuff into another decorator
            $_obj = new InternalCachingManipulator( $this, $this->get_extended_db(), $this->get_settings() ) ;
            $_obj = new HookSenderDecorator( $_obj );  // overrides methods to do some hooks
            $_obj = new UserHistoryDecorator( $_obj, $this->get_extended_db() ); // adds auditing and cruft
            $_obj = new FeuUserQueryDecorator( $_obj ); // adds functionality
            if( $this->cms->is_frontend_request() ) {
                // on the frontend queries can be cached
                $_obj = new CachedUserQueryDecorator( $_obj, $this->create_cache_driver(['group'=>__FILE__.'feu_queries']) );
            }
            $_obj = new UserEditDecorator( $_obj ); // adds functionality
            $_obj->register_authenticator(new BuiltInUserAuthenticator($this->get_extended_db()));
            // we could have some other dynamic decorators here.... maybe settable by a method
        }
        return $_obj;
    }

    /**
     * @ignore
     */
    function GetName() { return 'FrontEndUsers'; }

    /**
     * @ignore
     */
    function GetVersion() { return '3.2.2'; }

    /**
     * @ignore
     */
    function HasContentType() { return TRUE; }

    /**
     * @ignore
     */
    function IsPluginModule() { return TRUE; }

    /**
     * @ignore
     */
    function MinimumCMSVersion() { return '2.2.10'; }

    /**
     * @ignore
     */
    function GetAdminDescription () { return $this->Lang ('moddescription'); }

    /**
     * @ignore
     */
    function GetAdminSection () { return 'usersgroups'; }

    /**
     * @ignore
     */
    function GetDependencies() { return ['CGExtensions' => '1.64.2','CGSimpleSmarty' => '2.2.1' ]; }

    /**
     * @ignore
     */
    function GetFriendlyName () { return $this->Lang('friendlyname'); }

    /**
     * @ignore
     */
    function HasAdmin () { return TRUE; }

    /**
     * @ignore
     */
    function InstallPostMessage() { return $this->Lang('postinstallmessage'); }

    /**
     * @ignore
     * @deprecated
     */
    protected function langifyKeys( $arr ) : array
    {
        $out = [];
        foreach( $arr as $k=>$v ) {
            $k = $this->Lang($k);
            $out[ $k ] = $v;
        }
        return $out;
    }

    /**
     * @ignore
     */
    function SetParameters()
    {
        $smarty = cmsms()->GetSmarty();
        if( !$smarty ) return;

        static $_feu_smarty_plugins;
        $_feu_smarty_plugins = new feu_smarty_plugins($this);
        $smarty->registerClass('feu_smarty','feu_smarty');
        $smarty->registerPlugin('block','feu_protect', [$_feu_smarty_plugins, 'feu_protect']);
        $smarty->registerPlugin('function', 'feu_user_options', [$_feu_smarty_plugins, 'feu_user_options']);

        $contentops = $this->cms->GetContentOperations();

        $obj = new CmsContentTypePlaceholder();
        $obj->class = 'FrontEndUsers\ProtectedPage';
        $obj->type  = 'feu_protected_page';  // must be lowercase, and short, this is what is stored in the database.
        $obj->filename = __DIR__.'/lib/class.feu_protected_page.php';
        $obj->loaded = false;
        $obj->friendlyname = $this->Lang('feu_protected_page');
        $contentops->register_content_type($obj);

        $obj = new CmsContentTypePlaceholder();
        $obj->class = 'FrontEndUsers\ProtectedSectionHead';
        $obj->type  = 'feu_protected_sectionhead';
        $obj->filename = __DIR__.'/lib/class.feu_protected_sectionhead.php';
        $obj->loaded = false;
        $obj->friendlyname = $this->Lang('feu_protected_sectionhead');
        $contentops->register_content_type($obj);

        $obj = new CmsContentTypePlaceholder();
        $obj->class = 'feu_protected_logoutlink';
        $obj->type  = strtolower($obj->class);
        $obj->filename = __DIR__.'/lib/class.feu_protected_logoutlink.php';
        $obj->loaded = false;
        $obj->friendlyname = $this->Lang('feu_protected_logoutlink');
        $contentops->register_content_type($obj);

        static $_hooks_obj;
        if( !$_hooks_obj ) {
            $_hooks_obj = new hook_handler( $this, $this->get_settings() );
            HookManager::add_hook('FrontEndUsers::OnDeleteUser', [$_hooks_obj, 'hook_ondeleteuser'] );
            HookManager::add_hook('FrontEndUsers::OnUpdateUser', [$_hooks_obj, 'hook_onupdateuser_verificationemail'] );
            HookManager::add_hook('FrontEndUsers::AfterDeleteUser', [$_hooks_obj, 'hook_afterdeleteuser' ] );
        }
    }

    /**
     * @ignore
     */
    function InitializeFrontend()
    {
        parent::InitializeFrontend();
        $this->RegisterModulePlugin();
        /*  todo: clean this cruft up */
        $this->SetParameterType('code',CLEAN_STRING);
        $this->SetParameterType('only_groups',CLEAN_STRING);
        $this->SetParameterType('nocaptcha',CLEAN_INT);
        $this->SetParameterType('logouttemplate',CLEAN_STRING);
        $this->SetParameterType('logintemplate',CLEAN_STRING);
        $this->SetParameterType('post_logouttemplate',CLEAN_STRING);
        $this->SetParameterType('changesettingstemplate',CLEAN_STRING);
        $this->SetParameterType('forgotpwtemplate',CLEAN_STRING);
        $this->SetParameterType('forgotpwemailtemplate',CLEAN_STRING);
        $this->SetParameterType('lostuntemplate',CLEAN_STRING);
        $this->SetParameterType('lostunconfirmtemplate',CLEAN_STRING);
        $this->SetParameterType('forcenewpwtemplate',CLEAN_STRING);
        $this->SetParameterType('verifyformtemplate',CLEAN_STRING);
        $this->SetParameterType(CLEAN_REGEXP.'/feu_.*/',CLEAN_STRING);

        $this->RegisterRoute('/[fF]eu\/verifycode\/(?P<returnid>[0-9]+)\/(?P<uid>[0-9]+)\/(?P<code>.*?)$/',array('action'=>'verifycode'));
        $this->RegisterRoute('/[fF]eu\/verify\/(?P<returnid>[0-9]+)\/(?P<uid>[0-9]+)\/(?P<code>.*?)$/',array('action'=>'verifyonly'));
        $this->RegisterRoute('/[fF]eu\/edit\/(?P<returnid>[0-9]+)$/',array('action'=>'changesettings'));
        $this->RegisterRoute('/[fF]eu\/logout\/(?P<returnid>[0-9]+)$/',array('action'=>'logout'));
        $this->RegisterRoute('/[fF]eu\/forgot\/(?P<returnid>[0-9]+)$/',array('action'=>'forgotpw'));
        $this->RegisterRoute('/[fF]eu\/lostusername\/(?P<returnid>[0-9]+)$/',array('action'=>'lostusername'));
    }

    /**
     * @ignore
     */
    function get_tasks()
    {
        $out = null;

        $out[] = new \FrontEndUsers\ClearExpiredAuthTokensTask();

        // clear history task
        $tmp = $this->get_settings()->clearhistory_age;
        if( $tmp > 0 ) $out[] = new \FrontEndUsers\ClearUserHistoryTask($tmp);

        // clear expired temp codes
        $tmp = $this->get_settings()->tempcode_expiry_days;
        if( $tmp > 0 ) $out[] = new \FrontEndUsers\ClearExpiredTempCodesTask($tmp);

        // force logout at specific server times
        // no forced logout times if allowing rememberme
        $tmp = !$this->get_settings()->disable_rememberme && $this->get_settings()->forcelogout_times;
        if( $tmp ) $out[] = new FEUForcedLogoutTask($tmp,$this->get_settings()->forcelogout_sessionage);

        return $out;
    }

    /**
     * @ignore
     */
    public function get_pretty_url($id,$action,$returnid='',$params=array(),$inline=false)
    {
        if( $action == 'default' ) {
            $form = cge_param::get_string($params,'form');
            switch( $form ) {
            case 'forgotpw':
                $action = 'forgotpw';
                break;

            case 'login':
                $action = 'login';
                break;

            case 'lostusername':
                $action = 'lostusername';
                break;

            case 'changesettings':
                return "feu/edit/$returnid";
            }
        }

        if( $action == 'verifyonly' ) {
            $uid = cge_param::get_int($params,'uid');
            $code = cge_param::get_string($params,'code');
            if( $uid < 1 || !$code ) return;
            return "feu/verify/$returnid/$uid/$code";
        }
        else if( $action == 'verifycode' ) {
            $uid = cge_param::get_int($params,'uid');
            $code = cge_param::get_string($params,'code');
            if( cge_param::exists($params,'feu_verify') ) return;
            if( $uid < 1 || !$code ) return;
            return "feu/verifycode/$returnid/$uid/$code";
        }
        else if( $action == 'forgotpw') {
            return "feu/forgot/$returnid";
        } else if( $action == 'lostusername' ) {
            return "feu/lostusername/$returnid";
        } elseif( $action == 'logout' ) {
            return "feu/logout/$returnid";
        } elseif( $action == 'changesettings' ) {
            return "feu/edit/$returnid";
        }
    }

    /**
     * @ignore
     * @internal
     */
    public function have_permission(string $perm = '')
    {
        $pusers = $this->CheckPermission(self::PERM_USERS);
        $pgroups = $this->CheckPermission(self::PERM_GROUPS);
        $pprop = $this->CheckPermission(self::PERM_PROPS);
        return $pusers || $pgroups || $pprop;
    }

    /**
     * @ignore
     * @internal
     */
    protected function have_groups_perm()
    {
        return $this->CheckPermission(self::PERM_GROUPS);
    }

    /**
     * @ignore
     * @internal
     */
    protected function have_users_perm()
    {
        return $this->CheckPermission(self::PERM_USERS);
    }

    /**
     * @ignore
     * @internal
     */
    protected function have_props_perm()
    {
        return $this->CheckPermission(self::PERM_PROPS);
    }

    /**
     * @ignore
     */
    public function VisibleToAdminUser()
    {
        return $this->have_permission();
    }

    /**
     * @ignore
     */
    protected function _DisplayErrorPage($id, &$params, $returnid, $message='')
    {
        echo $this->DisplayErrorMessage($message);
    }

    /**
     * send an event that this user account has been expired
     *
     * @internal
     */
    public function NotifyExpiredUser( $userid )
    {
        $user = $this->GetUserInfo( $userid );
        if( $user[0] == FALSE ) return; // this should be an error
        $parms = array();
        $parms['id'] = $userid;
        $parms['username'] = $user[1]['username'];
        HookManager::do_hook('FrontEndUsers::OnExpireUser',$parms);
    }

    /**
     * @internal
     */
    public function is_allowed_upload($srcfile)
    {
        $allowed_extensions = $this->get_settings()->allowed_image_extensions;
        $tmp = explode( ',', strtolower($allowed_extensions));
        $srcfile = strtolower($srcfile);

        foreach( $tmp as $ext ) {
            if( endswith( $srcfile, $ext ) ) return TRUE;
        }
        return FALSE;
    }

    /**
     * @internal
     * @todo: move me out of here
     */
    public function get_upload_dirurl()
    {
        $dn = cms_join_path($this->config['uploads_url'],$this->get_settings()->image_destination_path);
        $dn = str_replace('\\','/',$dn);
        return $dn;
    }

    /**
     * @internal
     */
    public function get_upload_dirname()
    {
        $dn = cms_join_path($this->config['uploads_path'],$this->get_settings()->image_destination_path);
        return $dn;
    }

    /**
     * @internal
     */
    public function get_upload_filename($fldname,$srcfile)
    {
        // get the filename only, not the directory
        // note: this must be reproducable given the same srcfile and filename for the same request.
        $ext = strrchr($srcfile,'.');
        $time = cge_param::get_int( $_SERVER, 'REQUEST_TIME' );
        return sha1(__FILE__.session_id().$fldname.$srcfile.$time).$ext;
    }

    /**
     * @internal
     */
    public function ManageImageUpload($key, $fldname)
    {
        $res = \feu_utils::checkUpload($key);
        if( !$res[0] ) return $res;

        $file = $_FILES[$key];
        // set the destination name
        $destDir = $this->get_upload_dirname();
        $destname = $this->get_upload_filename($fldname,$file['name']);

        // Create the destination directory if necessary
        @mkdir($destDir,0777,TRUE);
        @touch($destdir.'/index.html');
        if( !is_writable( $destDir ) ) return [ false, $mod->Lang('error_destinationnotwritable') ];
        @cms_move_uploaded_file($file['tmp_name'], cms_join_path($destDir,$destname));

        return [ true, $destname ];
    }

    /**
     * @internal
     */
    public function SetPostLoginURL(string $url)
    {
        if( $url ) $this->session_put('postlogin_url',$url);
    }

    /**
     * @internal
     */
    protected function HasPostLoginUrl() : bool
    {
        return $this->session_get('postlogin_url') != '';
    }

    /**
     * @internal
     */
    protected function GetPostLoginURL()
    {
        $out = $this->session_get('postlogin_url');
        $this->session_clear('postlogin_url');
        return $out;
    }

    protected function create_cache_driver(array $opts) : cms_cache_driver
    {
        return new cms_filecache_driver($opts);
    }

    //////////////////////////////////////////
    //  API FUNCTIONS //
    //////////////////////////////////////////

    /**
     * Create a new query object.
     *
     * @returns feu_user_query
     */
    public function create_new_query() : feu_user_query
    {
        return $this->GetManipulator()->create_new_query();
    }

    /**
     * Given a valid user query, get the results.
     *
     * @param feu_user_query $query
     * @return userSet
     */
    public function get_query_results(feu_user_query $query) : userSet
    {
        return $this->GetManipulator()->get_query_results($query);
    }

    /**
     * Given a userSet containing 0 or more users create an array that can be used in a list.
     *
     * @param userSet $set
     * @return array
     */
    public function userset_to_lst(userSet $set)
    {
        return $this->GetManipulator()->userset_to_list($query);
    }

    /**
     * @ignore
     */
    public function __call( $name, $args )
    {
        return call_user_func_array( [ $this->GetManipulator(), $name ], $args );
    }

    /**
     * Get the filenames of all files associated with image properties for the specified user.
     * Does not check if the files exist, have thumbnails, or for permissions.
     *
     * @param int $userid The userid
     * @return array|null
     */
    function GetUserFilesFull( $userid )
    {
        $userid = (int) $userid;
        if( $userid < 1 ) return;

        $defns = $this->GetPropertyDefns();
        $propvals = $this->GetUserProperties( $userid );
        if( !$propvals ) return;
        $propvals = \cge_array::to_hash( $propvals, 'title' );
        $out = null;
        foreach( $defns as $name => $defn ) {
            if( $defn['type'] != self::FIELDTYPE_IMAGE ) continue;
            if( !isset( $propvals[$name]) ) continue;
            if( !$propvals[$name]['data'] ) continue;

            $out[$name] = $propvals[$name]['data'];
        }
        return $out;
    }


    /**
     * @internal
     * @ignore
     */
    function HasCapability($capability,$params = array())
    {
        switch( $capability ) {
        case 'content_types':
        case 'content_attributes':
        case 'tasks':
        case 'clicommands':
            return TRUE;
        default:
            return FALSE;
        }
    }

    /**
     * @internal
     * @ignore
     */
    public function get_cli_commands( $app )
    {
        $out = null;
        $out[] = new FrontEndUsers\Commands\GroupEditCommand($app, $this);
        $out[] = new FrontEndUsers\Commands\GroupListCommand($app, $this);
        $out[] = new FrontEndUsers\Commands\GroupListPropsCommand($app, $this);
        $out[] = new FrontEndUsers\Commands\GroupViewCommand($app, $this);
        $out[] = new FrontEndUsers\Commands\PropEditCommand($app, $this);
        $out[] = new FrontEndUsers\Commands\PropListCommand($app, $this);
        $out[] = new FrontEndUsers\Commands\UserAddCommand($app, $this->get_settings());
        $out[] = new FrontEndUsers\Commands\UserDeleteCommand( $app );
        $out[] = new FrontEndUsers\Commands\UserEditCommand($app, $this);
        $out[] = new FrontEndUsers\Commands\UserPropEditCommand($app, $this);
        $out[] = new FrontEndUsers\Commands\UserListCommand($app, $this);
        $out[] = new FrontEndUsers\Commands\UserViewCommand($app, $this);
        return $out;
    }

    /**
     * @internal
     * @ignore
     */
    function get_content_attributes($content_type)
    {
        $tmp = array();
        $attr = new CmsContentTypeProfileAttribute('feu_groups','visitors');
        $attr->set_helper(feu_content_attribute_helper::get_instance());
        $tmp[] = $attr;
        return $tmp;
    }

    /**
     * @ignore
     */
    public function get_settings() : settings
    {
        static $_obj;
        if( !$_obj ) {
            $data = [];
            $fn = $this->config['assets_path'].'/configs/feu_settings.json';
            if( is_file($fn) ) {
                $tmp = file_get_contents($fn);
                if( $tmp ) {
                    $tmp = json_decode($tmp,TRUE);
                    if( is_array($tmp) ) $data = $tmp;
                }
            }

            if( !defined('CONFIG_FILE_LOCATION') || !is_readable(CONFIG_FILE_LOCATION) ) throw new \LogicException('Could not read the config file');

            include(CONFIG_FILE_LOCATION);
            if( is_array($config) && !empty($config) ) $data = array_merge($config, $data);
            $_obj = new settings($data);
        }
        return $_obj;
    }

} // class

// EOF
