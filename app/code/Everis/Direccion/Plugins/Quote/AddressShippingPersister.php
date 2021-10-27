<?php

namespace Everis\Direccion\Plugins\Quote;

use \Magento\Quote\Model\QuoteRepository;
use \Zend\Log\Logger;
//use \Psr\Log\LoggerInterface as Logger;

class AddressShippingPersister
{

    protected $_quoteRepository;
    protected $_logger;

    public function __construct(
        QuoteRepository $quoteRepository,
        Logger $logger
    ){
        $this->_quoteRepository = $quoteRepository;
        $this->_logger = $logger;
        $writer = new \Zend\Log\Writer\Stream(BP.'/var/log/shipping-information.log');
        $this->_logger->addWriter($writer);
    }

    protected function log($message){
        $this->_logger->info($message);
    }

    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    ){
        if($addressInformation){
            try{
                $shippingAddress = $addressInformation->getShippingAddress();
                $billingAddress = $addressInformation->getBillingAddress();
                $extensionAttributes = $shippingAddress->getExtensionAttributes();
                $shippingAddress->setNeighborhood($extensionAttributes->getNeighborhood());
                $billingAddress->setNeighborhood($extensionAttributes->getNeighborhood());
                /*if($shippingAddress->getSameAsBilling()){

                }*/
                $this->log('Shipping Adress:');
                $this->log(print_r($shippingAddress->getData(),true));
                $this->log('Billing Adress:');
                $this->log(print_r($billingAddress->getData(),true));

                /*$quote = $this->_quoteRepository->getActive($cartId);
                $quote->getShippingAddress()->setData($shippingAddress->getData());//->save();
                $quote->getBillingAddress()->setData($billingAddress->getData()); //->save();*/

            }catch(\Exception $e){
                $this->log($e->getMessage());
            }
        }
    }

}
