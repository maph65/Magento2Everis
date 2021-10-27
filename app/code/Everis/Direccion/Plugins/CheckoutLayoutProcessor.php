<?php

namespace Everis\Direccion\Plugins;

use Magento\Framework\App\Config\ScopeConfigInterface;

class CheckoutLayoutProcessor
{

    private $logger;

    private $scope;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scope,
        \Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->scope = $scope;
    }

    /*public function beforeProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject,$jsLayout){
        $this->logger->debug('BEFORE PROCESS EXECUTED');
        return $jsLayout;
    }*/

    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject,$jsLayout){
        $neighborhoodAttributeCode = 'neighborhood';
        $neighborhoodField = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . $neighborhoodAttributeCode,
            'label' => 'Neighborhood',
            'provider' => 'checkoutProvider',
            'sortOrder' => 105,
            'validation' => [
                'required-entry' => true
            ],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
        ];
        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children'][$neighborhoodAttributeCode] = $neighborhoodField;

        $methodList = $this->scope->getValue('payment');
        if (isset($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'])
            && !empty($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children']) && !empty($methodList)) {

            //print_r($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']);die();

            $configuration = $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'];
            foreach ($configuration as $paymentGroup => $groupConfig) {
                if (isset($groupConfig['component']) AND $groupConfig['component'] === 'Magento_Checkout/js/view/billing-address') {

                    $neighborhoodField = [
                        'component' => 'Magento_Ui/js/form/element/abstract',
                        'config' => [
                            // customScope is used to group elements within a single form (e.g. they can be validated separately)
                            'customScope' => 'billingAddress',
                            'customEntry' => null,
                            'template' => 'ui/form/field',
                            'elementTmpl' => 'ui/form/element/input',
                        ],
                        'dataScope' => $groupConfig['dataScopePrefix'] . '.custom_attributes.' . $neighborhoodAttributeCode,
                        'label' => 'Neighborhood',
                        'provider' => 'checkoutProvider',
                        'sortOrder' => 105,
                        'validation' => [
                            'required-entry' => true
                        ],
                        'filterBy' => null,
                        'customEntry' => null,
                        'visible' => true,
                    ];
                    $configuration['billing-address-form']['children']['form-fields']['children'][$paymentGroup]['children']['form-fields']['children'][$neighborhoodAttributeCode] = $neighborhoodField;
                    //$configuration['billing-address-form']['children']['form-fields']['children'][$neighborhoodAttributeCode] = $neighborhoodField;
                    $jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children'] = $configuration;

                    /*echo 'Payment group: ';
                    print_r($paymentGroup);
                    echo 'Group config: ';
                    print_r($groupConfig);
                    print_r($configuration['billing-address-form']['children']['form-fields']['children'][$paymentGroup]);*/
                }
            }
            //print_r($jsLayout['components']['checkout']['children']['steps']['children']['billing-step']['children']['payment']['children']['payments-list']['children']);
            //die();

        }
        //print_r($jsLayout);
        //die();
        return $jsLayout;
    }

    /*public function aroundProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject,callable $proceed){
        $proceed();
    }*/

}
