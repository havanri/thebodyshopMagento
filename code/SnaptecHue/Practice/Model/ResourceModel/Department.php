<?php

namespace SnaptecHue\Practice\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Department extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('snaptechue_practice_department', 'entity_id');
    }
}
