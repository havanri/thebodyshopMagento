<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace SnaptecHue\Customer\Block\Account\Dashboard;
use Magento\Customer\Block\Account\Dashboard\Info as MagentoInfo;

/**
 * Dashboard Customer Info
 *
 * @api
 * @since 100.0.2
 */
class Info extends MagentoInfo
{
    /**
     * Get customer mobile number
     *
     * @return string|null
     */
    public function getCustomMobile()
    {
        $customer = $this->getCustomer();
        if ($customer && $customer->getId()) {
            return $customer->getCustomAttribute('custom_mobile') ? $customer->getCustomAttribute('custom_mobile')->getValue() : null;
        }
        return null;
    }
}
