<?php
namespace FrontEndUsers\Commands;
use FrontEndusers;
use CMSMS\CLI\App;
use CMSMS\CLI\GetOptExt\Command;
use CMSMS\CLI\GetOptExt\Option;
use CMSMS\CLI\GetOptExt\GetOpt;
use GetOpt\Operand;

class PropListCommand extends Command
{
    private $mod;

    public function __construct(App $app, FrontEndUsers $mod)
    {
        $this->mod = $mod;
        parent::__construct( $app, 'feu-props-list' );
        $this->addOption( Option::Create('r','raw')->setDescription('output raw data without cleaning'));
        $this->addOption( Option::Create('j','json')->setDescription('output data in JSON format'));
    }

    public function getShortDescription()
    {
        return 'List known FEU properties';
    }

    public function getLongDescription()
    {
        return 'This command will display a list of all of the properties known by FEU';
    }

    public function handle()
    {
        $defns = $this->mod->GetPropertyDefns();
        $raw = $this->getOption('raw')->value();
        $json = $this->getOption('json')->value();
        $types = $this->mod->GetFieldTypes();

        if( !$raw ) {
            array_walk($defns,function(&$item) use ($types) {
                    unset($item['attribs']);
                    switch( (int) $item['type'] ) {
                    case $this->mod::FIELDTYPE_TEXT:
                    case $this->mod::FIELDTYPE_TEXTAREA:
                        $item['length'] = (int) $item['length'];
                        $item['maxlength'] = (int) $item['maxlength'];
                        break;
                    default:
                        unset($item['length'],$item['maxlength']);
                        break;
                    }
                    if( !is_array($item['extra']) || empty($item['extra']) ) unset($item['extra']);
                    $item['force_unique'] = (bool) $item['force_unique'];
                });
        }

        if( $json ) {
           echo json_encode($defns, JSON_PRETTY_PRINT);
           exit;
        }

        $fmt = "%-20s %-30s %-10s %-4s %-4s %-3s\n";
        printf($fmt,"name","prompt","type","len","mlen","uni");
        printf($fmt,"----","-----","----","---","----","---");
        foreach( $defns as $one ) {
            printf($fmt, $one['name'], $one['prompt'], $one['type'],
                   (isset($one['length'])) ? $one['length'] : '',
                   (isset($one['maxlength'])) ? $one['maxlength'] : '',
                   $one['force_unique']);
        }
    }
} // end of class.
