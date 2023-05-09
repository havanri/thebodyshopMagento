<?php

namespace SnaptecHue\Payment\Model;

/**
 * MD Custom Payment Method Model
 */
class PaymentMethod extends \Magento\Payment\Model\Method\AbstractMethod
{

    const PAYMENT_METHOD_CUSTOM_PAYMENT_CODE = 'custom_payment';
    /**
     * Payment Method code
     *
     * @var string
     */
    protected $_code = self::PAYMENT_METHOD_CUSTOM_PAYMENT_CODE;

    protected $_isOffline = true;
    public function getPayableTo()
    {
        return $this->getConfigData('payable_to');
    }

    public function getMailingAddress()
    {
        return $this->getConfigData('mailing_address');
    }
}
