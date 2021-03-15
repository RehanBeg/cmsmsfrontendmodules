<?php
namespace CGFEURegister;
if( !isset($gCms) ) exit;

$db = $this->get_extended_db();
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'ENGINE=InnoDB');

$sqlarr = $dict->DropTableSQL($this->codes_table_name());
$dict->ExecuteSQLArray($sqlarr);
$sqlarr = $dict->DropTableSQL($this->users_table_name());
$dict->ExecuteSQLArray($sqlarr);
$this->RemovePreference();
