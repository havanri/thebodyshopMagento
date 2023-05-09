<?php

namespace SnaptecHue\Slider\Api;

interface CustomAttributeRepositoryInterface
{

    public function get($id);

    public function getCustomerOrderByDate($fromDate, $toDate);
}
