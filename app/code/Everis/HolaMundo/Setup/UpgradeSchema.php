<?php


namespace Everis\HolaMundo\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if(version_compare($context->getVersion(),'0.0.2','<')){
            $setup->startSetup();
            $newTable = $setup->getTable('everis_holamundo');
            if(!$setup->tableExists($newTable)){
                $table = $setup->getConnection()->newTable($newTable)->addColumn(
                    'entity_id',Table::TYPE_INTEGER,10,
                    array('primary'=>true,'nullable'=>false,'identity'=>true)
                )->addColumn('value',Table::TYPE_TEXT, 250,
                    array('nullable'=>true));
                $setup->getConnection()->createTable($table);
            }
            $setup->endSetup();
        }

        if(version_compare($context->getVersion(),'0.0.3','<')){

        }
    }
}
