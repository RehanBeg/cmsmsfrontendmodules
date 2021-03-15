<?php
namespace FrontEndUsers;
if( !isset($gCms) ) exit;
if( !$this->have_users_perm() ) return;
$this->SetCurrentTab('users');

try {
    $uid = \cge_param::get_int( $params, 'uid' );

    // generate a unique disabled username... something pretty much guaranteed to be unique
    $new_username = 'u'.sha1( time().__FILE__.rand() );
    $new_password = sha1( sha1( time().__FILE__.rand() ) );

    // todo: check if the new username exists

    // send a hook before anonimizing
    \CMSMS\HookManager::do_hook( 'FrontEndUsers::BeforeAnonimizeUser', $uid );

    $files = $this->GetUserFilesFull( $uid, TRUE );
    if( $files ) {
        $path = $this->get_upload_dirname();
        foreach( $files as $file ) {
            $fn = "$path/$file";
            $tn = "$path/thumb_{$file}";
            if( is_file($fn) && !is_writable($fn) ) throw new \RuntimeException("Insufficient permission to remove user file $file");
            if( is_file($tn) && !is_writable($tn) ) throw new \RuntimeException("Insufficient permission to remove user thumbnail for $file");
            if( is_file($tn) ) unlink($tn);
            if( is_file($fn) ) unlink($fn);
        }
    }

    // clear all the users properties
    $this->DeleteAllUserPropertiesFull( $uid );

    // we adjust the username, the password, and disable the account
    $this->SetUserDisabled( $uid );
    $this->SetUser( $uid, $new_username, $new_password );

    // delete all user history
    $sql = 'DELETE FROM '.cms_db_prefix().'module_feusers_history WHERE userid = ?';
    $db->Execute( $sql, [ $uid ] );

    // send a hook after anonimizing
    \CMSMS\HookManager::do_hook( 'FrontEndUsers::AfterAnonimizeUser', $uid );

    audit($uid,'FrontEndUsers','User anonimized');

    $this->SetMessage( $this->Lang('msg_anonimized') );
    $this->RedirectToTab();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToTab();
}
