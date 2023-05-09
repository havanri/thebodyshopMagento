<?php

namespace SnaptecHue\Payment\Model;

use SnaptecHue\Payment\Model\PaymentMethod;

class CustomPaymentConfigProvider implements \Magento\Checkout\Model\ConfigProviderInterface
{
    protected $methodCode = PaymentMethod::PAYMENT_METHOD_CUSTOM_PAYMENT_CODE;
    protected $method;
    protected $escaper;
    public function __construct(\Magento\Payment\Helper\Data $paymentHelper)
    {
        $this->method = $paymentHelper->getMethodInstance($this->methodCode);
    }
    public function getConfig()
    {
        return $this->method->isAvailable() ? [
            'payment' => [
                'custom_payment' => [
                    'mailingAddress' => $this->getMailingAddress(),
                    'payableTo' => $this->getPayableTo(),
                ],
            ],

        ] : [];
    }
    protected function getMailingAddress()
    {
        return $this->method->getMailingAddress();
    }
    protected function getPayableTo()
    {
        return $this->method->getPayableTo();
    }
}
