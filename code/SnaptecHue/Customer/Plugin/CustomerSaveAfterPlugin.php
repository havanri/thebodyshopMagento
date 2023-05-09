<?php

namespace SnaptecHue\Customer\Plugin;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;

class CustomerSaveAfterPlugin
{
    private $isProcessing = false;

    const CUSTOM_VARIABLE_CUSTOM_MOBILE = '55566609';
    public function afterSave(CustomerRepositoryInterface $subject, CustomerInterface $customer)
    {
        // if ($this->isProcessing) {
        //     return $customer;
        // }
        // $this->isProcessing = true;
        if ($customer->getCustomAttribute('custom_mobile') !== self::CUSTOM_VARIABLE_CUSTOM_MOBILE) {
            $customer->setCustomAttribute('custom_mobile', self::CUSTOM_VARIABLE_CUSTOM_MOBILE);
            $subject->save($customer);
        }
        // $this->isProcessing = false;
        return $customer;
    }
}
