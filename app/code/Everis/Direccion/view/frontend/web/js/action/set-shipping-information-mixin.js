define([
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote'
], function (wrapper,quote) {
    return function (setShippingInformationAction) {
        return wrapper.wrap(setShippingInformationAction,function(originalAction){
            var shippingAddress = quote.shippingAddress();

            if(typeof shippingAddress['extension_attributes'] == 'undefined'){
                shippingAddress['extension_attributes'] = {};
            }

            var neighborhood = '';
            if(typeof shippingAddress.customAttributes !== 'undefined' &&
            shippingAddress.customAttributes.length > 0){
                for(field in shippingAddress.customAttributes){
                    if(shippingAddress.customAttributes[field]['attribute_code'] == "neighborhood"){
                        neighborhood = shippingAddress.customAttributes[field]['value'];
                    }
                }
            }
            shippingAddress.extension_attributes.neighborhood = neighborhood;
            console.log(shippingAddress);
            return originalAction();
        });
    }
});
