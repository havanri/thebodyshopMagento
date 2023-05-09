<?php

namespace SnaptecHue\Sale\Model\Order\Config\Source;

use \Magento\Framework\Option\ArrayInterface;

class OrderStatus implements ArrayInterface
{
    public function toOptionArray()
    {
        $result = [];
        foreach ($this->getOptions() as $value => $label) {
            $result[] = [
                'value' => $value,
                'label' => $label,
            ];
        }
        return $result;
    }
    public function getOptions()
    {
        return [
            'yes' => __('Yes'),
            'no' => __('No'),
        ];
    }
}
