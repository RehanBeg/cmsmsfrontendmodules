<?php
declare(strict_types=1);
namespace FrontEndUsers;
use FrontEndusers;
use cge_param;
use cge_utils;

class hook_handler
{
    private $mod;
    private $settings;
    private $_userfiles;

    public function __construct( FrontEndusers $mod, settings $settings )
    {
        $this->mod = $mod;
        $this->settings = $settings;
    }

    public function hook_ondeleteuser( array $params )
    {
        // this hook checks if there are files to delete for this user
        // and that they can be deleted.  on error, throw an exception
        $this->_userfiles = null;
        $uid = (int) $params['id'];
        if( $uid < 1 ) return;

        $files = $this->mod->GetUserFilesFull( $uid, TRUE );
        if( !$files ) return;

        $path = $this->mod->get_upload_dirname();
        foreach( $files as $file ) {
            $fn = "$path/$file";
            $tn = "$path/thumb_{$file}";
            if( is_file($fn) && !is_writable($fn) ) throw new \RuntimeException("Insufficient permission to remove user file $file");
            if( is_file($tn) && !is_writable($tn) ) throw new \RuntimeException("Insufficient permission to remove user thumbnail for $file");
        }
        $this->_userfiles = $files;
        return $params;
    }

    public function hook_afterdeleteuser( array $params )
    {
        // this hook deletes all user files... does not throw an exception.
        // also deletes thumbnails.
        $uid = (int) $params['id'];
        if( $uid < 1 ) return;
        if( !$this->_userfiles ) return;
        $files = $this->_userfiles;
        $path = $this->mod->get_upload_dirname();

        foreach( $files as $file ) {
            $fn = "$path/$file";
            $tn = "$path/thumb_{$file}";
            if( is_file($fn) ) @unlink( $fn );
            if( is_file($tn) ) @unlink( $tn );
        }
        $this->_userfiles = null;
        return $params;
    }

    public function hook_onupdateuser_verificationemail( array $params )
    {
        // if a user has been edited, AND needs to verify themselves... then this function tests everything
        // and sends the user verification email
        try {
            if( ($uid = cge_param::get_int($params, 'id')) > 0 ) {

                $user = $this->mod->get_user($uid);
                if( !$user ) throw new \LogicException("could not get user $uid for ".__METHOD__);
                if( !$user->must_validate ) return $params;
                if( !$user->verify_code ) throw new \LogicException("user $uid must verify but has no verify code in ".__METHOD__);
                $email = $this->mod->GetEmail($uid);
                if( !$email ) throw new \LogicException("could not get email for user $uid in ".__METHOD__);
                $eml = $this->mod->get_email_storage()->load('notify_must_verify.eml');
                $eml = $eml->add_data('user', $user)
                    ->add_data('uid', $uid)
                    ->add_data('code', $user->verify_code)
                    ->add_data('pageid_onverify', $this->settings->pageid_onverify ?? $this->mod->GetContentManager()->GetDefaultContent())
                    ->add_address($email);
                $sender = $this->mod->create_new_mailprocessor($eml);
                $sender->send();
            }
        }
        catch( \Exception $e ) {
            cge_utils::log_exception($e);
        }
        return $params;
    }

} // class
