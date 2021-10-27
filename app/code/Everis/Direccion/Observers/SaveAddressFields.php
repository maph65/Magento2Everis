<?php

namespace Everis\Direccion\Observers;
use \Magento\Framework\Event\Observer;
use \Magento\Framework\Event\ObserverInterface;
use \Zend\Log\Logger;


class SaveAddressFields implements ObserverInterface
{

    protected $_logger;

    public function __construct(
        Logger $logger
    ){
        $this->_logger = $logger;
        $writer = new \Zend\Log\Writer\Stream(BP.'/var/log/quote-to-order.log');
        $this->_logger->addWriter($writer);
    }

    protected function log($message){
        $this->_logger->info($message);
    }

    public function execute(Observer $observer)
    {
        $this->log('Hola soy SaveAddressFields y he sido ejecutado');
        //$order = $observer->getData('order');
        $order = $observer->getOrder();
        $quote = $observer->getQuote();

        $shippingAddress = $quote->getShippingAddress();
        $billingAddress = $quote->getBillingAddress();

        $shippingNeighborhood = $shippingAddress->getNeighborhood();
        $billingNeighborhood = $billingAddress->getNeighborhood();

        $orderShippingAddress = $order->getShippingAddress();
        $orderBillingAddress = $order->getBillingAddress();

        $this->log('Neighborhood SA:'.$shippingNeighborhood);
        $this->log('Neighborhood BA:'.$billingNeighborhood);

        $orderShippingAddress->setNeighborhood($shippingNeighborhood);
        $orderBillingAddress->setData('neighborhood',$billingNeighborhood);
        $orderShippingAddress->save();
        $orderBillingAddress->save();

    }

}
