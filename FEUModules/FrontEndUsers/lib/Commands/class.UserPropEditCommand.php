<?php
namespace FrontEndUsers\Commands;
use FrontEndusers;
use CMSMS\CLI\App;
use CMSMS\CLI\GetOptExt\Command;
use CMSMS\CLI\GetOptExt\Option;
use CMSMS\CLI\GetOptExt\GetOpt;
use GetOpt\Operand;
use feu_user_query;
use feu_user_query_opt;

class UserPropEditCommand extends Command
{
    private $mod;

    public function __construct(App $app, FrontEndUsers $mod)
    {
        $this->mod = $mod;
        parent::__construct( $app, 'feu-user-propedit' );
        $this->addOperand( new Operand( 'username', Operand::REQUIRED ) );
        $this->addOperand( new Operand( 'property', Operand::REQUIRED ) );
        $this->addOperand( new Operand( 'propertyvalue', Operand::OPTIONAL ) );
        $this->addOption( Option::Create('f','force')->setDescription('Ignore propdefn type, and set the value anyways') );
        $this->addOption( Option::Create(null,'delete')->setDescription('Delete the property value and, if an image property any associated image') );
    }

    public function getShortDescription()
    {
        return 'Edit FEU user properties';
    }

    public function getLongDescription()
    {
        return 'This command allows simple modification of user properties.  The user is NOT notified of any changes to his account';
    }

    public function handle()
    {
        $username = trim($this->getOperand('username')->value());
        $property = trim($this->getOperand('property')->value());
        $propvalue = trim($this->getOperand('propertyvalue')->value());
        $force = trim($this->getOption('force'));
        $delete = trim($this->getOption('delete'));

        $uid = $this->mod->GetUserID($username);
        if( $uid < 1 ) throw new \RuntimeException("User $username not found");

        $defns = $this->mod->GetPropertyDefns();
        if( empty($defns) || !isset($defns[$property]) ) throw new \RuntimeException('Property '.$property.' not found');

        $defn = $defns[$property];
        if( !$force && ($defn['type'] == $this->mod::FIELDTYPE_DATA || $defn['type'] == $this->mod::FIELDTYPE_IMAGE) ) {
            throw new \RuntimeException("Sorry, properties of this type cannot be manipulated.");
        }

        if( $delete ) {
            if( $defn['type'] == $this->mod::FIELDTYPE_IMAGE ) {
                // gotta get the current value for this property if there is one
                $val = $this->mod->GetUserPropertyFull($property,$uid);
                if( $val ) {
                    // should delete image files here.
                    $config = cmsms()->GetConfig();
                    $fn = $config['uploads_path']."/_feusers/$val";
                    if( is_file($fn) ) unlink($fn);
                }
            }
            $this->mod->DeleteUserPropertyFull($property,$uid);
        }
        else {
            // now we can set the property value.
            $this->mod->SetUserPropertyFull($property,$propvalue,$uid);
        }
    }
} // end of class.
