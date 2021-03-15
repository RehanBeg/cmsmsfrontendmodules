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

class UserViewCommand extends Command
{
    private $mod;

    public function __construct(App $app, FrontEndUsers $mod)
    {
        $this->mod = $mod;
        parent::__construct( $app, 'feu-user-view' );
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
        $query = $this->mod->create_new_query();
        $query->set_webready();
        $query->set_deep();
        $query->add_and_opt( feu_user_query_opt::MATCH_USERNAME, $username );
        $rs = $this->mod->get_query_results($query);
        if( count($rs) !== 1 ) throw new \RuntimeException('User not found');
        $data = $rs->current()->to_array();
        $data = json_encode($data,JSON_PRETTY_PRINT);
        echo $data."\n";
    }
} // end of class.
