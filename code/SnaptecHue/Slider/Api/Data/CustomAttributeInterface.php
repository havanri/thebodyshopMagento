<?php

namespace SnaptecHue\Slider\Api\Data;

interface CustomAttributeInterface {
    const VALUE = 'status_grand_total_custom';		
		
    /**
     * Get custom attribute value.
     *
     * @return string
     */
    public function getValue();

    /**
     * Set custom attribute value.
     *
     * @param string $value
     * @return $this
     */
    public function setValue($value);
}