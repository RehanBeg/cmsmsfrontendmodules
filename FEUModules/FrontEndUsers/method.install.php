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

if( version_compare(phpversion(),'7.2.1') < 0 ) {
    return "Minimum PHP version of 7.2.1 required";
}

$log_exception = function(\Exception $e) {
    $out = '-- EXCEPTION DUMP --'."\n";
    $out .= "TYPE: ".get_class($e)."\n";
    $out .= "MESSAGE: ".$e->getMessage()."\n";
    $out .= "FILE: ".$e->getFile().':'.$e->GetLine()."\n";
    $out .= "TREACE:\n";
    $out .= $e->getTraceAsString();
    debug_to_log($out,'-- '.__METHOD__.' --');
};

$db = $this->get_extended_db();
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'ENGINE=InnoDB');

//User list
$flds = "
         id I KEY AUTO NOTNULL,
         username C(128) NOTNULL,
         password C(128) NOTNULL,
         createdate ".CMS_ADODB_DT.",
         expires    ".CMS_ADODB_DT.",
         nonstd   I1,
         disabled I1,
         salt     C(64),
         force_newpw I1,
         force_chsettings I1,
         must_validate I1,
         extra X
        ";
$sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX."module_feusers_users", $flds, $taboptarray );
$dict->ExecuteSQLArray( $sqlarray );

//Group list
$flds = "
	     id I KEY AUTO NOTNULL,
	     groupname C(32) NOTNULL,
	     groupdesc C(128)
	    ";
$sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX."module_feusers_groups", $flds, $taboptarray );
$dict->ExecuteSQLArray( $sqlarray );

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

//Connections between users and groups
$flds = "
	     userid I KEY NOTNULL,
	     groupid I KEY NOTNULL
	    ";
$sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX."module_feusers_belongs", $flds, $taboptarray );
$dict->ExecuteSQLArray( $sqlarray );

//property definition
$flds = "
         name      C(40) KEY NOTNULL,
         prompt    C(255) NOTNULL,
         type      C(20) NOTNULL,
         length    I,
         maxlength I,
         attribs   C(255),
         force_unique I1,
         encrypt   I1,
         extra     X
        ";
$sqlarray = $dict->CreateTableSql(CMS_DB_PREFIX."module_feusers_propdefn", $flds, $taboptarray );
$dict->ExecuteSQLArray( $sqlarray );

//dropdown select options
$flds = "
         order_id		I NOTNULL,
         option_name	C(40) NOTNULL,
         option_text	C(255) NOTNULL,
         control_name	C(40) NOTNULL;
        ";
$sqlarray = $dict->CreateTableSql(CMS_DB_PREFIX."module_feusers_dropdowns", $flds, $taboptarray );
$dict->ExecuteSQLArray( $sqlarray );

// group property map
// used to associate a property to a group
$flds = "
         name    C(40) KEY NOTNULL,
         group_id I KEY NOTNULL,
         sort_key I NOTNULL,
         required I NOTNULL,
        ";
$sqlarray = $dict->CreateTableSql(CMS_DB_PREFIX."module_feusers_grouppropmap", $flds, $taboptarray );
$dict->ExecuteSQLArray( $sqlarray );

//user properties
$flds = "
	     id I KEY AUTO NOTNULL,
	     userid I NOTNULL,
	     title C(100) NOTNULL,
	     data X2
	    ";
$sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX."module_feusers_properties", $flds, $taboptarray );
$dict->ExecuteSQLArray( $sqlarray );
//$db->CreateSequence( CMS_DB_PREFIX."module_feusers_properties_seq" );

// forgotten password stuff
$flds = "
	     userid I KEY,
         code C(25) NOTNULL,
         created ".CMS_ADODB_DT;
$sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX."module_feusers_tempcode", $flds, $taboptarray );
$dict->ExecuteSQLArray( $sqlarray );

// login history stuff
$flds = "
         userid I NOTNULL,
	     sessionid C(32) NOTNULL,
         action C(255) NOTNULL,
         refdate ".CMS_ADODB_DT.",
         ipaddress C(64)";
$sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX."module_feusers_history", $flds, $taboptarray );
$dict->ExecuteSQLArray( $sqlarray );

// indexes
$sqlarray = $dict->CreateIndexSQL(CMS_DB_PREFIX.'feu_idx_belongs',CMS_DB_PREFIX.'module_feusers_belongs','groupid');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(CMS_DB_PREFIX.'feu_idx_username',CMS_DB_PREFIX.'module_feusers_users','username');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(CMS_DB_PREFIX.'feu_idx_expires',CMS_DB_PREFIX.'module_feusers_users','expires');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(CMS_DB_PREFIX.'feu_idx_refdate',CMS_DB_PREFIX.'module_feusers_history','userid,refdate,action');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(CMS_DB_PREFIX.'feu_idx_propusertitle',CMS_DB_PREFIX.'module_feusers_properties','userid,title');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(CMS_DB_PREFIX.'feu_idx_proptitle',CMS_DB_PREFIX.'module_feusers_properties','title');
$dict->ExecuteSQLArray($sqlarray);

// setup foreign key relationships
$sql = 'ALTER TABLE '.CMS_DB_PREFIX.'module_feusers_belongs ADD FOREIGN KEY (userid) REFERENCES '.CMS_DB_PREFIX.'module_feusers_users (id)';
$db->Execute($sql);
$sql = 'ALTER TABLE '.$this->tokens_table_name().' ADD FOREIGN KEY (uid) REFERENCES '.CMS_DB_PREFIX.'module_feusers_users (id)';
$db->Execute($sql);
$sql = 'ALTER TABLE '.CMS_DB_PREFIX.'module_feusers_belongs ADD FOREIGN KEY (groupid) REFERENCES '.CMS_DB_PREFIX.'module_feusers_groups (id)';
$db->Execute($sql);
$sql = 'ALTER TABLE '.CMS_DB_PREFIX.'module_feusers_dropdowns ADD FOREIGN KEY (control_name) REFERENCES '.CMS_DB_PREFIX.'module_feusers_propdefn (name)';
$db->Execute($sql);
$sql = 'ALTER TABLE '.CMS_DB_PREFIX.'module_feusers_grouppropmap ADD FOREIGN KEY (group_id) REFERENCES '.CMS_DB_PREFIX.'module_feusers_groups (id)';
$db->Execute($sql);
$sql = 'ALTER TABLE '.CMS_DB_PREFIX.'module_feusers_grouppropmap ADD FOREIGN KEY (name) REFERENCES '.CMS_DB_PREFIX.'module_feusers_propdefn (name)';
$db->Execute($sql);
$sql = 'ALTER TABLE '.CMS_DB_PREFIX.'module_feusers_properties ADD FOREIGN KEY (userid) REFERENCES '.CMS_DB_PREFIX.'module_feusers_users (id)';
$db->Execute($sql);
$sql = 'ALTER TABLE '.CMS_DB_PREFIX.'module_feusers_properties ADD FOREIGN KEY (title) REFERENCES '.CMS_DB_PREFIX.'module_feusers_propdefn (name)';
$db->Execute($sql);
$sql = 'ALTER TABLE '.CMS_DB_PREFIX.'module_feusers_tempcode ADD FOREIGN KEY (userid) REFERENCES '.CMS_DB_PREFIX.'module_feusers_users (id)';
$db->Execute($sql);
$sql = 'ALTER TABLE '.CMS_DB_PREFIX.'module_feusers_history ADD FOREIGN KEY (userid) REFERENCES '.CMS_DB_PREFIX.'module_feusers_users (id)';
$db->Execute($sql);

// preferences
$this->SetPreference('notification_subject',$this->Lang('feu_event_notification'));

// usersalt = 0/unset : md5  hash with fixed salt for all users
// usersalt = 1 : sha1 hash with user specific salt
// usersalt = 3 : use php's password_encrypt, and password_verify with bcrypt
$this->SetPreference('use_usersalt',2);

// permissions
$this->CreatePermission(FrontEndUsers::PERM_PROPS, 'Modify FrontEndUser Properties');
$this->CreatePermission(FrontEndUsers::PERM_USERS, 'Modify Front-End Users');
$this->CreatePermission(FrontEndUsers::PERM_GROUPS, 'Modify Front-End User Groups');
