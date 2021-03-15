<?php
namespace CGFEURegister;
if( !isset($gCms) ) exit;

$db = $this->get_extended_db();
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'ENGINE=InnoDB');

$flds = "
      id I KEY AUTO NOTNULL,
      username C(256) NOTNULL,
      created I NOTNULL,
      sig C(256) NOTNULL,
      data X2 NOTNULL
";
$sqlarr = $dict->CreateTableSQL($this->users_table_name(), $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarr);
$sqlarray = $dict->CreateIndexSQL(CMS_DB_PREFIX.'mod_cgfr_idx0',$this->users_table_name(),'username', [ 'UNIQUE' ]);
$dict->ExecuteSQLArray($sqlarray);

$flds = "
      uid I KEY NOTNULL,
      verify_code C(64) KEY NOTNULL,
      expires I NOTNULL
";
$sqlarr = $dict->CreateTableSQL($this->codes_table_name(), $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarr);
$sqlarray = $dict->CreateIndexSQL(CMS_DB_PREFIX.'mod_cgfr_idx1',$this->codes_table_name(),'username');
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(CMS_DB_PREFIX.'mod_cgfr_idx2',$this->codes_table_name(),'verify_code', ['UNIQUE']);
$dict->ExecuteSQLArray($sqlarray);
// todo: foreign key relationship on id

$key = bin2hex(random_bytes(64)).__FILE__;
$key = hash('sha256',$key);
$key = hash('sha256',$key);
$this->SetPreference($this->regManager()::ENCRYPTION_KEY,$key);