<?php
namespace SnaptecHue\Slider\Api;

interface CustomerOrderInterface{
    /**
     * Get customer order list by date range
     *
     * @api
     * @param string $fromDate
     * @param string $toDate
     * @return array
     */
    public function getCustomerOrderList($fromDate, $toDate);
}