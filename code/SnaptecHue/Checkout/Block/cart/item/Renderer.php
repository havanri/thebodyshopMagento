<?php

namespace SnaptecHue\Checkout\Block\Cart\Item;

use Magento\Checkout\Block\Cart\Item\Renderer as OriginRenderer;

class Renderer extends OriginRenderer
{
    protected function _getProduct()
    {
        if (!$this->getData('product') instanceof \Magento\Catalog\Model\Product) {
            $this->setData('product', $this->getProduct());
        }
        return $this->getData('product');
    }

    public function getProductBrand()
    {
        $product = $this->_getProduct();
        $attributeValue = $product->getAttributeText('product_brand');
        return $attributeValue;
    }
}