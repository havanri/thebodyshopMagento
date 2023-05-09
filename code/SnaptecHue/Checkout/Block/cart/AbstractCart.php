<?php

namespace SnaptecHue\Checkout\Block\Cart;

class AbstractCart
{

    public function afterGetItemRenderer(\Magento\Checkout\Block\Cart\AbstractCart $subject, $result)
    {
        $result->setTemplate('Magento_Checkout::cart/item/default.phtml');
        return $result;
    }
}
