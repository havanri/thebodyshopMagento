<?php

namespace SnaptecHue\Practice\Model\ResourceModel\Employee;

use Magento\Eav\Model\Entity\Collection\AbstractCollection;


class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'SnaptecHue\Practice\Model\Employee',
            'SnaptecHue\Practice\Model\ResourceModel\Employee'
        );
    }
}
