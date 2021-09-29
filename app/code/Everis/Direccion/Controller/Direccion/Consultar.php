<?php

namespace Everis\Direccion\Controller\Direccion;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Everis\Direccion\Model\NeighborhoodFactory;
use Everis\Direccion\Model\Resource\Neighborhood as NeighborhoodResourceModel;
use Everis\Direccion\Model\Resource\Neighborhood\CollectionFactory as NeighborhoodCollection;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\App\RequestInterface;

class Consultar extends Action{

    protected $_neigborhood;
    protected $_jsonFactory;
    protected $_request;
    protected $_redirectFactory;
    protected $_resourceModel;
    protected $_collection;

    public function __construct(
        NeighborhoodFactory $_neigborhood,
        JsonFactory $_jsonFactory,
        RequestInterface $_request,
        RedirectFactory $_redirectFactory,
        NeighborhoodResourceModel $_resourceModel,
        NeighborhoodCollection $_collection,
        Context $context)
    {
        parent::__construct($context);
        $this->_neigborhood = $_neigborhood;
        $this->_jsonFactory = $_jsonFactory;
        $this->_request = $_request;
        $this->_redirectFactory = $_redirectFactory;
        $this->_resourceModel = $_resourceModel;
        $this->_collection = $_collection;
    }

    public function execute()
    {
        /*$result = array('result'=> true, 'message'=>'Todo funciona OK');
        $response = $this->_jsonFactory->create();
        return $response->setData($result);*/

        //echo "{ 'result':1,'message':'Todo funciona OK' }";

        /*$response = $this->_redirectFactory->create();
        //$response->setUrl('https://www.google.com');
        $response->setUrl('/privacy-policy-cookie-restriction-mode/');
        $response->setHttpResponseCode('302');
        return $response;*/
        //$params = $this->_request->getParams();
        //$response = $this->_jsonFactory->create();
        //return $response->setData($params);
        //echo $this->_request->getParam('param1');

        $result = array('result'=> false, 'message'=> __('Postal code is required'));

        //$neigborhood = $this->_neigborhood->create();
        //$neigborhood = $neigborhood->load(1);  //Esto es incorrecto, método load esta deprecated
        //$this->_resourceModel->load($neigborhood,1000,'postal_code');
        //print_r($neigborhood->getData());

        $postalCode = $this->_request->getParam('postalcode');
        if((int)$postalCode){

            $neigborhoodCollection = $this->_collection->create();
            $neigborhoodCollection->addFieldToFilter('postal_code',array('eq'=>(int)$postalCode))->load();
            if($neigborhoodCollection->getSize()){
                foreach ($neigborhoodCollection as $neigborhood) {
                    print_r($neigborhood->getData());
                }
            }
            die();
            $result = array('result'=> true, 'message'=> __('Success'));
        }
        $response = $this->_jsonFactory->create();
        return $response->setData($result);
    }


}
