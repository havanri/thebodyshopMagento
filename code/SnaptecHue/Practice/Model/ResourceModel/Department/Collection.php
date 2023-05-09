<?php

namespace SnaptecHue\Practice\Model\ResourceModel\Department;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            'SnaptecHue\Practice\Model\Department',
            'SnaptecHue\Practice\Model\ResourceModel\Department'
        );
    }
}
