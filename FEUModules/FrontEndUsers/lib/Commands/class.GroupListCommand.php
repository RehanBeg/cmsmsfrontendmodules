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

class GroupListCommand extends Command
{
    private $mod;

    public function __construct(App $app, FrontEndUsers $mod)
    {
        $this->mod = $mod;
        parent::__construct( $app, 'feu-group-list' );
        $this->addOption( Option::Create('j','json')->setDescription('output data in JSON format'));
    }

    public function getShortDescription()
    {
        return 'List FEU groups';
    }

    public function getLongDescription()
    {
        return 'This command will return a list of FEU groups.';
    }

    public function handle()
    {
        $json = $this->getOption('json')->value();
        $list = $this->mod->GetGroupListFull();
        if( empty($list)) return;

        $tmp = null;
        foreach( $list as $row ) {
            $row['id'] = (int) $row['id'];
            $row['count'] = (int) $row['count'];
            $tmp[] = $row;
        }
        $list = $tmp;

        if( $json ) {
            echo json_encode( $list, JSON_PRETTY_PRINT );
            return;
        }

        $fmt = "%-4s %-40s %-4s %-s\n";
        printf($fmt,'id','name','count','description');
        printf($fmt,'--','----','----','----');
        foreach( $list as $rec ) {
            printf($fmt,$rec['id'],$rec['groupname'],$rec['count'],$rec['groupdesc']);
        }
    }
} // end of class.
