<?php

namespace SnaptecHue\Slider\Model;

use SnaptecHue\Slider\Api\Data\CustomAttributeInterface;

class CustomAttribute implements CustomAttributeInterface
{
    /**		
     * {@inheritdoc}		
     */
    public function getValue()
    {
        return $this->getData(self::VALUE);
    }

    /**		
     * {@inheritdoc}		
     */
    public function setValue($value)
    {
        return $this->setData(self::VALUE, $value);
    }
}
