<?php
namespace FrontEndUsers\Commands;
use FrontEndUsers\settings;
use CMSMS\CLI\App;
use CMSMS\CLI\GetOptExt\Command;
use CMSMS\CLI\GetOptExt\Option;
use CMSMS\CLI\GetOptExt\GetOpt;
use GetOpt\Operand;
use feu_user_query;
use feu_user_query_opt;

class UserAddCommand extends Command
{
    private $expireage_months;

    public function __construct( App $app, settings $settings )
    {
        parent::__construct( $app, 'feu-user-add' );
        $this->addOperand( new Operand( 'username', Operand::REQUIRED ) );
        $this->addOperand( new Operand( 'password', Operand::REQUIRED ) );
        $this->addOperand( new Operand( 'group', Operand::MULTIPLE ) );
        $this->addOption( Option::Create('p','prop', GetOpt::MULTIPLE_ARGUMENT)->setDescription('A user property in the form of name=value') );
        $this->addOption( Option::Create('f','force')->setDescription('Ignore email address checks, and allow specifying unknown properties'));
        $this->expireage_months = $settings->expireage_months;
    }

    public function getShortDescription()
    {
        return 'Add a new FEU User account';
    }

    public function getLongDescription()
    {
        return 'Add a new FEU user to one or more groups';
    }

    public function handle()
    {
        $username = trim($this->getOperand('username')->value());
        $password = trim($this->getOperand('password')->value());
        $groups = $this->getOperand('group')->value();
        $props = $this->getOption('prop')->value();
        $force = $this->getOption('force')->value();
        if( empty($groups) ) throw new \RuntimeException('Please specify one or more group names');

        // now validate the groups
        $feu = \cms_utils::get_module(MOD_FRONTENDUSERS);
        $defns = $feu->GetPropertyDefns();
        $allgroups = $feu->GetGroupList();

        // validate that the username does not already exist
        $test_uid = $feu->GetUserID($username);
        if( $test_uid > 0 ) throw new \RuntimeException('The username '.$username.' already exists');
        if( !$force && !$feu->IsValidUsername($username, true) ) {
            throw new \RuntimeException($username.' is not a valid email address, or is already used.');
        }

        // validate the specified group names.
        $groupnames = array_keys($allgroups);
        $err_groups = array_diff($groups, $groupnames);
        if( !empty($err_groups) ) throw new \RuntimeException('One or more groups specified does not exist');

        // get all of the properties for each of these groups
        $gid_list = array_map(function($item) use ($allgroups){
                return (int) $allgroups[$item];
            }, $groups);
        $gid_list = array_unique($gid_list);
        $allprops = $feu->GetMultiGroupPropertyRelations($gid_list);

        // get a list of the properties that are allowed
        //   (not of type data)
        $allowed_props = array_filter($allprops, function($item) use ($defns, $feu){
                $name = $item['name'];
                if( !isset($defns[$name]) ) return;
                if( $defns[$name]['type'] == $feu::FIELDTYPE_DATA ) return;
                if( $defns[$name]['type'] == $feu::FIELDTYPE_IMAGE ) return;
                return TRUE;
            });
        $allowed_props = array_map(function($item){
                return $item['name'];
            }, $allowed_props);

        // now get all of our required properties
        $required = array_filter($allprops,function($item){
                return $item['required'] == 2;
            });
        $required = array_map(function($item){
                return $item['name'];
            }, $required);

        // now parse our property options
        $gather_props = function($props) {
            $out = [];
            if( is_array($props) ) {
                foreach( $props as $prop_opt ) {
                    list($prop_name,$value) = explode('=',$prop_opt,2);
                    $prop_name = trim($prop_name);
                    $value = trim($value);
                    if( $prop_name ) {
                        $out[$prop_name] = $value;
                    }
                }
            }
            return $out;
        };

        // now, see if we have any of these props
        $valid_props = $gather_props($props);
        $prop_keys = array_keys($valid_props);

        // if we have required properties, make sure they were all specified.
        if( !empty($required)) {
            if( !empty(array_diff($required,$prop_keys)) ) throw new \RuntimeException("The following properties are required according to the groups specified: ".implode(',',$required));
        }

        // make sure all of our properties are known.
        $not_allowed = array_diff($prop_keys,$allowed_props);
        if( !empty($not_allowed) ) throw new \RuntimeException('The following properties do not exist: '.implode($not_allowed));

        // add the user
        $tmp = $this->expireage_months;
        $expires = strtotime("+{$tmp} months 00:00");
        if( !$expires ) $expires = PHP_INT_MAX;

        $res = $feu->AddUser( $username, $password, $expires );
        if( !is_array($res) || !isset($res[0]) || !$res[0] ) throw new \RuntimeException('Could not create user: '.$res[1]);;
        $uid = $res[1];

        // add him to his groups
        foreach( $groups as $group ) {
            $gid = $allgroups[$group];
            $res = $feu->AddUserToGroup( $uid, $gid );
            if( !$res ) throw new \RuntimeException('Problem adding user to group... creation incomplete');
        }

        // set properties
        if( $valid_props ) {
            foreach( $valid_props as $prop_name => $value ) {
                $res = $feu->SetUserPropertyFull($prop_name,$value,$uid);
                if( !$res ) throw new \RuntimeException('Problem setting user properties... creation incomplete');
            }
        }

        // and done.
    }

} // end of class.
