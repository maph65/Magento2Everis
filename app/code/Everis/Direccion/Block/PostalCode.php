<?php

namespace Everis\Direccion\Block;

use Magento\Framework\View\Element\Template;
use Everis\Direccion\Model\NeighborhoodFactory;
use Everis\Direccion\Model\Resource\Neighborhood\CollectionFactory as NeighborhoodCollection;

class PostalCode extends \Magento\Framework\View\Element\Template
{

    protected $_neigborhood;
    protected $_neigborhoodCollection;
    protected $_context;
    protected $_postalCode;

    public function __construct(
        NeighborhoodFactory $_neigborhood,
        NeighborhoodCollection $_collection,
        Template\Context $context,
        array $data = [])
    {
        $this->_neigborhood = $_neigborhood;
        $this->_neigborhoodCollection = $_collection;
        $this->_context = $context;
        parent::__construct(
            $context,
            $data);
    }

    protected function getPostalCode(){
        if(!$this->_postalCode){
            $this->_postalCode = $this->_context->getRequest()->getParam('postal_code');
        }
        return $this->_postalCode;
    }

    public function getTitle(){
        $postalCode = $this->getPostalCode();
        return 'Información del Código Postal '.$postalCode;
    }

    public function getPostalCodeInfo(){
        $postalCode = $this->getPostalCode();
    }

    public function getNeigborhoods(){
        if($this->getPostalCode()){
            $ncf = $this->_neigborhoodCollection->create();
            $ncf->addFieldToFilter('postal_code',$this->getPostalCode());
            return $ncf->load();
        }else{
            return false;
        }
    }

}
