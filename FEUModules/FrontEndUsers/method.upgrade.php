<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: FrontEndUsers (c) 2008-2014 by Robert Campbell
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
if( !isset($gCms) ) exit;

if( version_compare(phpversion(),'7.2.1') < 0 ) return "Minimum PHP version of 7.2.1 required";
if( version_compare($oldversion,'2.12.3.99') < 0 ) return 'Sorry, this version does not allow upgrade from versions before version 2.12.4';

///////////////////////////////////////////////////////////

$db = $this->get_extended_db();
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'ENGINE=InnoDB');

if( version_compare($oldversion,'2.12.4') < 0 ) {
      $sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_feusers_users", "salt C(64)");
      $dict->ExecuteSQLArray($sqlarray);
}
if( version_compare($oldversion,'2.13') < 0 ) {
    $this->SetPreference('use_usersalt',2);
}
if( version_compare($oldversion,'2.13.9') < 0 ) {
      $sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_feusers_users", "password C(128)");
      $dict->ExecuteSQLArray($sqlarray);
}
if( version_compare($oldversion,'2.99') < 0 ) {
    $generic_type = CmsLayoutTemplateType::load('Core::Generic');
    if( !$generic_type ) return 'Cannot get generic template type object';

    // create some settings and store them.
    $dir = $this->config['assets_path'].'/configs';
    if( !is_dir($dir) ) @mkdir($dir);
    if( is_dir($dir) ) {
        $fn = $dir.'/feu_settings.json';
        if( !is_file($fn) ) {
            $arr = [
                'username_is_email' => (bool) $this->GetPreference('username_is_email'),
                'disable_forgotpw' => !$this->GetPreference('support_lostpw'),
                'disable_lostusername' => !$this->GetPreference('support_lostun'),
                'allow_changeusername' => (bool) $this->GetPreference('allow_changeusername'),
                'default_group' => (int) $this->GetPreference('default_group'),
                'require_onegroup' => (bool) $this->GetPreference('require_onegroup'),
                'min_passwordlength' => (int) $this->GetPreference('min_passwordlength'),
                'max_passwordlength' => (int) $this->GetPreference('max_passwordlength'),
                'enhanced_passwords' => (bool) $this->GetPreference('enhanced_password'),
                'password_requiredchars' => trim($this->GetPreference('password_requiredchars')),
                'min_usernamelength' => $this->GetPreference('min_usernamelength'),
                'max_usernamelength' => $this->GetPreference('max_usernamelength'),
                'required_field_marker' => $this->GetPreference('required_field_marker'),
                'required_field_color' => $this->GetPreference('required_field_color'),
                'hidden_field_marker' => $this->GetPreference('hidden_field_marker'),
                'hidden_field_color' => $this->GetPreference('hidden_field_color'),
                'login_after_verify' => (bool) $this->GetPreference('login_after_verify'),
                'expireage_months' => (int) $this->GetPreference('expireage_months'),
                'image_destination_path' => trim($this->GetPreference('image_destination_path')),
                'allowed_image_extensions' => trim($this->GetPreference('allowed_image_extensions')),
                'forcelogout_times' => trim($this->GetPreference('forcelogout_times')),
                'pagetype_groups' => trim($this->GetPreference('pagetype_groups')),
                ];
            $json = json_encode($arr,JSON_PRETTY_PRINT);
            file_put_contents($fn,$json);
        }
    }

    // create permissions
    $this->RemovePermission('FEU Modify Users');
    $this->RemovePermission('FEU Modify Groups');
    $this->RemovePermission('FEU Modify FrontEndUserProps');

    // get the generic template type.
    // find all templates with this originator
    // change them all to this type
    $types = CmsLayoutTemplateType::load_all_by_originator($this->GetName());
    if( is_array($types) && count($types) ) {
        foreach( $types as $type ) {
            $tpls = CmsLayoutTemplate::template_query(array('t:'.$type->get_id()));
            if( is_array($tpls) && count($tpls) ) {
                foreach( $tpls as $tpl ) {
                    $tpl->set_type($generic_type);
                    $tpl->save();
                }
            }
            $type->delete();
        }
    }

    $sqlarray = $dict->AddColumnSQL(CMS_DB_PREFIX.'module_feusers_users','extra X');
    $dict->ExecuteSQLArray($sqlarray);

    $flds = "
         uid I KEY NOTNULL,
         code C(64) KEY NOTNULL,
         last_updated I NOTNULL,
         expires I NOTNULL,
         created I NOTNULL
    ";
    $sqlarray = $dict->CreateTableSQL($this->tokens_table_name(), $flds, $taboptarray);
    $sqlarr = $dict->CreateIndexSQL(CMS_DB_PREFIX.'module_feusers_idx_tokens1', $this->tokens_table_name(), 'code', ['UNIQUE'] );
    $dict->ExecuteSQLArray($sqlarray);

    // remove the events and event handlers (contentpostrender)
    $this->RemoveEvent( 'AfterLoginAuth' );
    $this->RemoveEvent( 'BeforeLogin' );
    $this->RemoveEvent( 'OnLogin' );
    $this->RemoveEvent( 'OnLogin' );
    $this->RemoveEvent( 'OnLoginFailed' );
    $this->RemoveEvent( 'OnLogout' );
    $this->RemoveEvent( 'OnExpireUser' );
    $this->RemoveEvent( 'OnCreateUser' );
    $this->RemoveEvent( 'OnDeleteUser' );
    $this->RemoveEvent( 'OnCreateGroup' );
    $this->RemoveEvent( 'OnDeleteGroup' );
    $this->RemoveEvent( 'OnUpdateUser' );

    $this->RemoveEventHandler('Core','ContentPostRender');
    $this->RemoveEventHandler('CGEcommerceBase','OrderUpdated');
    $this->RemoveEventHandler('CGEcommerceBase','OrderDeleted');
}
