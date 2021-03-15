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
use cms_utils;

class GroupViewCommand extends Command
{
    public function __construct(App $app, FrontEndUsers $mod)
    {
        $this->mod = $mod;
        parent::__construct( $app, 'feu-group-view' );
        $this->addOperand( Operand::Create( 'group', Operand::REQUIRED)->setDescription('The group name') );
        $this->addOption( Option::Create('j','json')->setDescription('Output data in json format') );
    }

    public function getShortDescription()
    {
        return 'Edit an FEU Group definition';
    }

    public function getLongDescription()
    {
        return 'Edit an FEU Group definition';
    }

    public function handle()
    {
        $group = trim($this->getOperand('group')->value());
        $json = $this->GetOption('json')->value();
        $required_vals = [ 0=>'off', 1=>'optional', 2=>'required', 3=>'hidden', 4=>'readonly' ];
        $gid = $this->mod->GetGroupID( $group );
        if( $gid < 1 ) throw new \RuntimeException("Group $group not found");
        $ginfo = $this->mod->GetGroupInfo( $gid );
        $ginfo['description'] = $ginfo['groupdesc'];
        $ginfo['name'] = $ginfo['groupname'];
        $ginfo['count'] = (int) $ginfo['count'];
        unset($ginfo['groupdesc'], $ginfo['groupname']);

        $relns = $this->mod->GetGroupPropertyRelations( $gid );
	if( !empty($relns) ) {
		print_r($relns);
            array_walk($relns,function(&$item) use ($required_vals) {
                    $item['group_id'] = (int) $item['group_id'];
                    $item['sort_key'] = (int) $item['sort_key'];
                    $item['required'] = $required_vals[$item['required']];
                });
            usort($relns,function($a,$b){
                    if( $a['sort_key'] != $b['sort_key'] ) return $a['sort_key'] - $b['sort_key'];
                    return strcmp($a['name'],$b['name']);
            });
            $ginfo['properties'] = $relns;
        }

        if( $json ) {
            echo json_encode($ginfo,JSON_PRETTY_PRINT);
            return;
        }

        echo "ID: {$ginfo['id']}\n";
        echo "NAME: {$ginfo['name']}\n";
        echo "DESCRIPTION: {$ginfo['description']}\n";
        echo "MEMBERS: {$ginfo['count']}\n";
        if( $ginfo['properties' ] ) {
            $fmt = "PROPERTY: name=%s status=%s\n";
            foreach( $ginfo['properties'] as $row ) {
                printf($fmt, $row['name'], $row['required']);
            }
        }
    }
} // end of class.
