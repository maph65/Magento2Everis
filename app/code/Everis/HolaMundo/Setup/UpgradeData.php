<?php

namespace Everis\HolaMundo\Setup;

use Everis\HolaMundo\Model\Resource\EverisHolamundoDbschema as EverisHolamundoDbschemaResource;
use Everis\HolaMundo\Model\EverisHolamundoDbschemaFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


class UpgradeData implements UpgradeDataInterface {

    protected $_everisHolamundoDbsResource;

    protected $_everisHolamundoDbsFactory;

    public function __construct(
        EverisHolamundoDbschemaFactory $factory,
        EverisHolamundoDbschemaResource $resource
    )
    {
        $this->_everisHolamundoDbsFactory = $factory;
        $this->_everisHolamundoDbsResource = $resource;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if(version_compare($context->getVersion(),'0.0.2','<')) {
            $setup->startSetup();
            $data = [
                array('value' => 'value01'),
                array('value' => 'value02'),
            ];
            $table = $setup->getTable('everis_holamundo');
            $setup->getConnection()->insertMultiple($table, $data);
            $setup->endSetup();
        }

        if(version_compare($context->getVersion(),'0.0.3','<')) {
            $setup->startSetup();
            $holamundo = $this->_everisHolamundoDbsFactory->create();
            $holamundo->setValue('valor 1');
            $holamundo->setOldvalue('valor anterior 1');
            $this->_everisHolamundoDbsResource->save($holamundo);
            $setup->endSetup();
        }

    }

}


?>
