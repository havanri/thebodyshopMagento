<?php

namespace SnaptecHue\Practice\Model\ResourceModel;

use Magento\Eav\Model\Entity\AbstractEntity;

class Employee extends AbstractEntity{

    protected function _construct()
    {
        $this->_read = 'snaptechue_practice_employee_read';
        $this->_write = 'snaptechue_practice_employee_write';
    }
    public function getEntityType(){
        if(empty($this->_type)){
            $this->setType(\SnaptecHue\Practice\Model\Employee::ENTITY);
        }
        return parent::getEntityType();
    }
}