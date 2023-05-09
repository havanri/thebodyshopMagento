define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'custom_payment',
                component: 'SnaptecHue_Payment/js/view/payment/method-renderer/custom_payment'
            }
        );
        return Component.extend({});
    }
);