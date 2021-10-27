<?php

namespace Everis\Direccion\Controller\Direccion;

use \Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\Result\RedirectFactory;

class Detalle extends Action{

    protected $_pageFactory;
    protected $_context;
    protected $_redirectFactory;

    public function __construct(
        PageFactory $_pageFactory,
        RedirectFactory $_redirectFactory,
        Context $context)
    {
        $this->_pageFactory = $_pageFactory;
        $this->_context = $context;
        $this->_redirectFactory = $_redirectFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $postalCode = $this->_context->getRequest()->getParam('postal_code');
        if((int)$postalCode){
            return $this->_pageFactory->create();
        }else{
            return $this->_redirectFactory->create()->setUrl($this->_context->getUrl()->getBaseUrl());
        }
    }

}
