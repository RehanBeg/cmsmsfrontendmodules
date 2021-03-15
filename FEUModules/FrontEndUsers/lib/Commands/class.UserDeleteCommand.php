<?php
namespace FrontEndUsers\Commands;
use CMSMS\CLI\App;
use CMSMS\CLI\GetOptExt\Command;
use CMSMS\CLI\GetOptExt\Option;
use CMSMS\CLI\GetOptExt\GetOpt;
use GetOpt\Operand;
use feu_user_query;
use feu_user_query_opt;

class UserDeleteCommand extends Command
{
    public function __construct( App $app )
    {
        parent::__construct( $app, 'feu-user-del' );
        $this->addOperand( new Operand( 'username', Operand::REQUIRED ) );
    }

    public function getShortDescription()
    {
        return 'List FEU users';
    }

    public function getLongDescription()
    {
        return 'This command will return a list of FEU users filtered by various criteria';
    }

    public function handle()
    {
        $username = trim($this->getOperand('username')->value());
        $feu = \cms_utils::get_module(MOD_FRONTENDUSERS);
        $uid = $feu->GetUserID($username);
        if( $uid < 1 ) throw new \RuntimeException("User $username not found");

        try {
            $res = $feu->DeleteUserFull($uid);
            if( !is_array($res) || !isset($res[0]) || !$res[0] ) {
                throw new \RuntimeException($res[1]);
            }
        }
        catch( \Exception $e ) {
            throw new \RuntimeException('User delete failed: '.$e->GetMessage());
        }
    }
} // end of class.
