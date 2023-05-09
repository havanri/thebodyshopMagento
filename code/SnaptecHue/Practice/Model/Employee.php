<?php

namespace SnaptecHue\Practice\Model;

use Magento\Framework\Model\AbstractModel;

class Employee extends AbstractModel
{

    const ENTITY = 'snaptechue_practice_employee';
    public function _construct()
    {
        $this->_init('SnaptecHue\Practice\Model\ResourceModel\Employee');
    }
}
