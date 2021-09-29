<?php

namespace Everis\Direccion\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

use Magento\Eav\Model\Config;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

use Everis\Direccion\Model\NeighborhoodFactory;
use Everis\Direccion\Model\Resource\Neighborhood as NeighborhoodResource;


class UpgradeData implements UpgradeDataInterface {

    protected $_customerSetupFactory;
    protected $_eavConfig;
    protected $_attributeSetFactory;
    protected $_neighborhoodResourceModel;
    protected $_neighborhoodFactory;

    public function __construct(
        Config $_config,
        CustomerSetupFactory $_customerSetupFactory,
        AttributeSetFactory $_attributeSetFactory,
        NeighborhoodFactory $_neighborhoodFactory,
        NeighborhoodResource $_neighborhoodResourceModel
    )
    {
        $this->_customerSetupFactory = $_customerSetupFactory;
        $this->_attributeSetFactory = $_attributeSetFactory;
        $_config = $_config;
        $this->_neighborhoodFactory = $_neighborhoodFactory;
        $this->_neighborhoodResourceModel = $_neighborhoodResourceModel;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if(version_compare($context->getVersion(),'0.0.2','<')) {
            $setup->startSetup();
            $customerSetup = $this->_customerSetupFactory->create(['setup' => $setup ]);
            $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer_address');
            $attributeSetId = $customerEntity->getDefaultAttributeSetId();

            $attributeSet = $this->_attributeSetFactory->create();
            $attributeSetGroupId = $attributeSet->getDefaultGroupId($attributeSetId);

            $customerSetup->addAttribute(
                'customer_address',
                'neighborhood',
                array(
                    'type' => 'varchar',
                    'input' => 'text',
                    'label' => 'Neighborhood',
                    'global' => 1,
                    'visible' => 1,
                    'required' => 0,
                    'user_defined' => 1,
                    'visible_on_front' => 1,
                    'sort_order' => 710,
                    'position' => 710
                )
            );

            $neigborhoodAttribute = $customerSetup->getEavConfig()->getAttribute('customer_address','neighborhood');
            $neigborhoodAttribute->setData('attribute_set_id',$attributeSetId);
            $neigborhoodAttribute->setData('attribute_group_id',$attributeSetGroupId);
            $neigborhoodAttribute->setData(
                'used_in_forms', ['adminhtml_customer_address','customer_address_edit','customer_register_address']
            );
            $neigborhoodAttribute->save();

            $setup->endSetup();
        }

        if(version_compare($context->getVersion(),'0.0.3','<')) {
            $setup->startSetup();
            $array = array(
                1000 => 'Colonia Ejemplo 1',
                2000 => 'Colonia Ejemplo 2',
                3000 => 'Colonia Ejemplo 3',
                4000 => 'Colonia Ejemplo 4',
                5000 => 'Colonia Ejemplo 5',
            );
            foreach ($array as $key => $val) {
                $neigborhood = $this->_neighborhoodFactory->create();
                $neigborhood->setPostalCode($key);
                $neigborhood->setNeighborhood($val);
                $this->_neighborhoodResourceModel->save($neigborhood);
            }

            $setup->endSetup();
        }
    }


}


?>
