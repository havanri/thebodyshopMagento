/*browser:true*/
/*global define*/
define(["Magento_Checkout/js/view/payment/default"], function (Component) {
    "use strict";

    return Component.extend({
        defaults: {
            template: "SnaptecHue_Payment/payment/custom_payment",
        },
        getMailingAddress: function () {
            return window.checkoutConfig.payment.custom_payment.mailingAddress;
        },
        getPayableTo: function () {
            return window.checkoutConfig.payment.custom_payment.payableTo;
        },
    });
});
