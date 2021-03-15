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

class GroupEditCommand extends Command
{
    public function __construct(App $app, FrontEndUsers $mod)
    {
        $this->mod = $mod;
        parent::__construct($app, 'feu-group-edit');
        $this->addOperand( Operand::Create('group', Operand::REQUIRED)->setDescription('An existing group name') );
        $this->addOption( Option::Create(null,'rename', GetOpt::REQUIRED_ARGUMENT)->setDescription('Adjust the group name'));
        $this->addOption( Option::Create(null,'description', GetOpt::REQUIRED_ARGUMENT)->setDescription('Adjust the group description'));
        // feu-group-edit users newdesc --rename foobar --description stuff
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
        $newname = trim($this->getOption('rename')->value());
        $newdesc = trim($this->getOption('description')->value());

        $gid = $this->mod->GetGroupID( $group );
        if( $gid < 1 ) throw new \RuntimeException("Group $group not found");
        $desc = $this->mod->GetGroupDesc( $gid );

        if( !$newname && !$newdesc ) throw new \RuntimeException('Please specify at least one of the rename or description options');
        if( $newname ) {
            // validate the group name
            if( !preg_match('#[a-z0-9][_\-a-z0-9]*#i', $newname) ) throw new \RuntimeException("Invalid group name $newname");
            // validate that this new name is not used
            $new_gid = $this->mod->GetGroupID( $newname );
            if( $new_gid > 0 ) throw new \RuntimeException("Group name $newname already exists");
        }

        // get the group info
        if( $newname ) $group = $newname;
        if( $newdesc ) $desc  = $newdesc;

        $this->mod->SetGroup( $gid, $group, $desc );
    }
} // end of class.
