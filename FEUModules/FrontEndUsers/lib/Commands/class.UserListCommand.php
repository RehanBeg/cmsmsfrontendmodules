<?php
namespace FrontEndUsers\Commands;
use FrontEndUsers\AbstractUser;
use FrontEndUsers;
use CMSMS\CLI\App;
use CMSMS\CLI\GetOptExt\Command;
use CMSMS\CLI\GetOptExt\Option;
use CMSMS\CLI\GetOptExt\GetOpt;
use GetOpt\Operand;
use feu_user_query;
use feu_user_query_opt;

class UserListCommand extends Command
{
    private $mod;

    public function __construct(App $app, FrontEndUsers $mod)
    {
        $this->mod = $mod;
        parent::__construct( $app, 'feu-user-list' );
        $this->addOperand( Operand::create('group', Operand::OPTIONAL)
                           ->setDescription('An optional group name, use an empty string to specify all groups if also using a pattern.') );
        $this->addOperand( Operand::create('pattern', Operand::OPTIONAL)
                           ->setDescription('An optional username pattern.  wildcards are accepted i.e: *@domain.com') );
        $this->addOption( Option::Create('l','limit')->setDescription('Page limit (default 500)') );
        $this->addOption( Option::Create('o','offset')->setDescription('Start index (default 0)') );
        $this->addOption( Option::Create('j','json')->setDescription('Output data in JSON format') );
        $this->addOption( Option::Create(null,'loggedin')->setDescription('Display only loggedin users') );
        $this->addOption( Option::Create(null,'expired')->setDescription('Display only loggedin users') );
        $this->addOption( Option::Create(null,'disabled')->setDescription('Display only disabled users') );
        $this->addOption( Option::Create(null,'created-before')->setDescription('Filter on users created before the specified date') );
        $this->addOption( Option::Create(null,'created-after')->setDescription('Filter on users created after the specified date') );
        $help = <<<EOT
Sorting of the output.   Possible values are: CREATED_DESC*, CREATED_ASC, USERNAME_ASC, USERNAME_DESC, EXPIRES_ASC, EXPIRES_DESC
EOT;
        $this->addOption( Option::Create(null,'sortby')->setDescription($help)->setDefaultValue('CREATED_DESC') );
    }

    public function getShortDescription()
    {
        return 'List FEU users';
    }

    public function getLongDescription()
    {
        return 'This command will return a list of FEU users filtered by various criteria';
    }

    protected function normal_output(AbstractUser $row)
    {
        $fmt = "%-8d %-40s\n";
        printf($fmt,$row['id'],$row['username']);
    }

    public function handle()
    {
        $pattern = trim($this->getOperand('pattern')->value());
        $group = trim($this->getOperand('group')->value());
        $limit = (int) $this->GetOption('limit')->value();
        if( $limit < 1 ) $limit = 500;
        $limit = min(100000,500);
        $offset = (int) $this->GetOption('offset')->value();
        $offset = max($offset,0);
        $loggedin = (int) $this->GetOption('loggedin')->value();
        $disabled = (int) $this->GetOption('disabled')->value();
        $expired = (int) $this->GetOption('expired')->value();
        $created_before = trim($this->GetOption('created-before'));
        $created_after = trim($this->GetOption('created-after'));
        $json = $this->GetOption('json')->value();

        $query = $this->mod->create_new_query();
        $query->set_pagelimit($limit);
        $query->set_offset($offset);
        if( $pattern ) $query->add_and_opt( feu_user_query_opt::MATCH_USERNAME, $pattern );
        if( $group ) $query->add_and_opt( feu_user_query_opt::MATCH_GROUP, $group );
        if( $loggedin !== 0 ) $query->add_and_opt( feu_user_query_opt::MATCH_LOGGEDIN );
        if( $expired !== 0 ) $query->add_and_opt( feu_user_query_opt::MATCH_EXPIRES_LT, time() );
        if( $disabled !== 0 ) $query->add_and_opt( feu_user_query_opt::MATCH_DISABLED );
        if( $created_before ) {
            $ts = strtotime($created_before);
            if( !$ts ) throw new \LogicException("Could not convert $ts to a valid time value... see strtotime");
            $query->add_and_opt( feu_user_query_opt::MATCH_CREATED_LT, $ts );
        }
        if( $created_after ) {
            $ts = strtotime($created_after);
            if( !$ts ) throw new \LogicException("Could not convert $ts to a valid time value... see strtotime");
            $query->add_and_opt( feu_user_query_opt::MATCH_CREATED_GE, $ts );
        }

        $sortby = $this->GetOption('sortby')->value();
        if( !$sortby ) $sortby = 'CREATED_DESC';
        switch( strtoupper($sortby) ) {
        case 'CREATED_ASC':
            $query->set_sortby( $query::RESULT_SORTBY_CREATED );
            $query->set_sortorder( $query::RESULT_SORTORDER_ASC );
            break;
        case 'CREATED_DESC':
            $query->set_sortby( $query::RESULT_SORTBY_CREATED );
            $query->set_sortorder( $query::RESULT_SORTORDER_DESC );
            break;
        case 'USERNAME_ASC':
            $query->set_sortby( $query::RESULT_SORTBY_USERNAME );
            $query->set_sortorder( $query::RESULT_SORTORDER_ASC );
            break;
        case 'USERNAME_DESC':
            $query->set_sortby( $query::RESULT_SORTBY_USERNAME );
            $query->set_sortorder( $query::RESULT_SORTORDER_DESC );
            break;
        case 'EXPIRES_ASC':
            $query->set_sortby( $query::RESULT_SORTBY_EXPIRES );
            $query->set_sortorder( $query::RESULT_SORTORDER_ASC );
            break;
        case 'EXPIRES_DESC':
            $query->set_sortby( $query::RESULT_SORTBY_EXPIRES );
            $query->set_sortorder( $query::RESULT_SORTORDER_DESC );
            break;
        default:
            throw new \InvalidArgumentException("$sortby is not a valid sort option");
        }

	$fix_row = function($row) {
  	    $out = null;
	    print_r($row);	
            $out['id'] = (int) $row['id'];
            $out['nonstd'] = (int) $row['nonstd'];
            $out['disabled'] = (int) $row['disabled'];
            $out['force_newpw'] = (int) $row['force_newpw'];
            $out['force_chsettings'] = (int) $row['force_chsettings'];
            $out['must_validate'] = (int) $row['must_validate'];
            $out['loggedin'] = (int) $row['loggedin'];
            return $row;
        };

        $rs = $this->mod->get_query_results($query);
        if( !count($rs) ) {
            die('done');
        }

        if( $json ) {
            $out = null;
            while( !$rs->EOF() ) {
		$row = $rs->fields;
		$out[] = $fix_row($row);   
                $rs->MoveNext();
            }
            echo json_encode($out,JSON_PRETTY_PRINT);
            return;
        }

        while( !$rs->EOF() ) {
            $this->normal_output( $rs->fields );
            $rs->MoveNext();
        }
        exit();
    }
} // end of class.
