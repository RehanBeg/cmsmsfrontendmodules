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

class PropEditCommand extends Command
{
    private $mod;

    public function __construct(App $app, FrontEndUsers $mod)
    {
        $this->mod = $mod;
        parent::__construct( $app, 'feu-prop-edit' );
        $this->addOperand( Operand::create( 'prop', Operand::REQUIRED )->setDescription('The property to edit') );
        $this->addOperand( Operand::create( 'filename', Operand::OPTIONAL )->setDescription('The json file containing the property information.  If not specified, read from stdin.') );
    }

    public function getShortDescription()
    {
        return 'Edit an FEU Property definition';
    }

    public function getLongDescription()
    {
        $out = <<<EOT
Edit an FEU Property definition given JSON input.  If a filename is not provided, then stdin is asumed.

Note. it is possible to break an existing site with this command.  Use caution.
EOT;
    }

    public function handle()
    {
        $prop = trim($this->getOperand('prop')->value());
        $filename = trim($this->getOperand('filename')->value());
        if( !$filename || $filename == '--' ) $filename = 'php://stdin';
        $text = trim(file_get_contents($filename));

        $defn = $this->mod->GetPropertyDefn($prop);
        if( !$defn ) throw new \RuntimeException("Property $prop not found");

        $json = json_decode($text,TRUE);
        if( !is_array($json) || empty($json) ) throw new \RuntimeException('Cannot decode json input');

        $prop_rec = null;
        if( !isset($json[$prop]) || !is_array($json[$prop]) ) {
            if( isset($json['name']) || isset($json['type']) || isset($json['prompt']) ) {
                $prop_rec = $json;
            } else {
                throw new \RuntimeException('Invalid JSON data');
            }
        } else {
            $prop_rec = $json[$prop];
        }

        // now merge the defn info with the prop_rec
        $prop_rec = array_merge($defn,$prop_rec);
        $res = $this->mod->SetPropertyDefn( $prop, $prop_rec['name'], $prop_rec['prompt'], $prop_rec['length'], $prop_rec['type'],
                                      $prop_rec['maxlength'], $prop_rec['attribs'], $prop_rec['force_unique'] );
        if( !$res ) throw new \RuntimeException('Property update failed');
    }
} // end of class.
