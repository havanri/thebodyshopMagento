<?php

namespace SnaptecHue\Practice\Model;

use Magento\Framework\Model\AbstractModel;

class Department extends AbstractModel{
    protected function _construct()
    {
        $this->_init('SnaptecHue\Practice\Model\ResourceModel\Department');
    }
}