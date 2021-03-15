<?php
namespace FrontEndUsers\Commands;
use CMSMS\CLI\App;
use CMSMS\CLI\GetOptExt\Command;
use CMSMS\CLI\GetOptExt\Option;
use CMSMS\CLI\GetOptExt\GetOpt;
use GetOpt\Operand;
use feu_user_query;
use feu_user_query_opt;

class GroupListPropsCommand extends Command
{
    public function __construct( App $app )
    {
        parent::__construct( $app, 'feu-group-list-props' );
        $this->addOperand( new Operand( 'group', Operand::REQUIRED ) );
        $this->addOption( Option::Create('r','raw')->setDescription('output raw data without cleaning'));
        $this->addOption( Option::Create('j','json')->setDescription('output data in JSON format'));
    }

    public function getShortDescription()
    {
        return 'List FEU group properties';
    }

    public function getLongDescription()
    {
        return 'This command will display a list of the property associations for a group';
    }

    public function handle()
    {
        $feu = \cms_utils::get_module(MOD_FRONTENDUSERS);
        $group = $this->getOperand('group')->value();
        $json = $this->getOption('json')->value();
        $raw = $this->getOption('raw')->value();

        $gid = $feu->GetGroupID($group);
        if( $gid < 1 ) throw new \RuntimeException("Group $group not found");

        $relns = $feu->GetGroupPropertyRelations($gid);
        if( empty($relns) ) return;

        $get_required = function(array $rec) {
            $arr = [ 0=>'off', 1=>'optional', 2=>'required', 3=>'hidden', 4=>'readonly' ];
            $v = (int) $rec['required'];
            if( isset($arr[$v]) ) return $arr[$v];
            return '*unknown*';
        };

        usort($relns,function($a,$b){
                if( $a['sort_key'] != $b['sort_key'] ) return $a['sort_key'] - $b['sort_key'];
                return strcmp($a['name'],$b['name']);
            });

        if( $json ) {
            array_walk($relns,function(&$item) use ($raw,$get_required){
                    $item['group_id'] = (int) $item['group_id'];
                    $item['sort_key'] = (int) $item['sort_key'];
                    if( !$raw ) {
                        $item['required'] = $get_required($item);
                    }
                });
            echo json_encode($relns, JSON_PRETTY_PRINT);
            return;
        }

        $fmt = "%-20s %-8s\n";
        printf($fmt,'name','required');
        printf($fmt,'----','---');
        foreach( $relns as $rec ) {
            // output the property name, required,
            printf($fmt, $rec['name'], $get_required($rec));
        }
    }
} // end of class.
