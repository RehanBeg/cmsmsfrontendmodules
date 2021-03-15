<?php
namespace FrontEndUsers\Commands;
use FrontEndUsers;
use CMSMS\CLI\App;
use CMSMS\CLI\GetOptExt\Command;
use CMSMS\CLI\GetOptExt\Option;
use CMSMS\CLI\GetOptExt\GetOpt;
use GetOpt\Operand;
use feu_user_query;
use feu_user_query_opt;

class UserEditCommand extends Command
{
    private $mod;

    public function __construct(App $app, FrontEndusers $mod)
    {
        $this->mod = $mod;
        parent::__construct( $app, 'feu-user-edit' );
        $this->addOperand( new Operand( 'username', Operand::REQUIRED ) );
        $this->addOption( Option::Create(null,'username', GetOpt::REQUIRED_ARGUMENT)->setDescription('Adjust the users username') );
        $this->addOption( Option::Create(null,'password', GetOpt::REQUIRED_ARGUMENT)->setDescription('Adjust the users password') );
        $this->addOption( Option::Create(null,'expires', GetOpt::REQUIRED_ARGUMENT)->setDescription('Adjust the users expiry date') );
        $this->addOption( Option::Create(null,'force-changepw', GetOpt::OPTIONAL_ARGUMENT)->setDescription('Force the user to change his password on the next login') );
        $this->addOption( Option::Create(null,'disabled', GetOpt::OPTIONAL_ARGUMENT)->setDescription('Toggle users disabled state') );
    }

    public function getShortDescription()
    {
        return 'Edit FEU user info';
    }

    public function getLongDescription()
    {
        return 'This command allows simple modification of user settings.  The user is NOT notified of any changes to his account';
    }

    public function handle()
    {
        $username = trim($this->getOperand('username')->value());
        $new_username = trim($this->getOption('username'));
        $new_password = trim($this->getOption('password'));
        $new_expires = trim($this->getOption('expires'));
        $disabled = trim($this->getOption('disabled')->value());
        $force_changepw = trim($this->getOption('force-changepw')->value());

        $uid = $this->mod->GetUserID($username);
        if( $uid < 1 ) throw new \RuntimeException('User not found');

        if( !$new_username && !$new_password && !$new_expires && !strlen($disabled) && !strlen($force_changepw)) {
            throw new \RuntimeException('Please specify at least one option');
        }

        if( !empty($new_username) ) {
            // check that this username doesn't already exist.
        } else {
            $new_username = $username;
        }

        if( !empty($new_expires) ) {
            $new_expires = strtotime($new_expires);
            if( !$new_expires ) throw new \RuntimeException('Could not determine a time from the expires string specified');
        } else {
            $new_expires = null;
        }

        if( !empty($new_username) || !empty($new_password) || $new_expires > 0 ) {
            $this->mod->SetUser( $uid, $new_username, $new_password, $new_expires );
        }
        if( strlen($disabled) ) $this->mod->SetUserDisabled( $uid, $disabled );
        if( strlen($force_changepw) ) {
            $this->mod->ForcePasswordChange($uid, $force_changepw);
        }
    }
} // end of class.
