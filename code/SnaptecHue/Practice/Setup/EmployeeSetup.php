<?php

namespace SnaptecHue\Practice\Setup;

use Magento\Eav\Setup\EavSetup;

class EmployeeSetup extends EavSetup
{

    public function getDefaultEntities()
    {
        /* create our own entity */
        $employeeEntity = \SnaptecHue\Practice\Model\Employee::ENTITY;

        $entities = [
            $employeeEntity => [
                'entity_model' => 'SnaptecHue\Practice\Model\ResourceModel\Employee',
                'table' => $employeeEntity . '_entity',
                'attributes' => [
                    'department_id' => [
                        'type' => 'static',
                    ],
                    'email' => [
                        'type' => 'static'
                    ],
                    'first_name' => [
                        'type' => 'static'
                    ],
                    'last_name' => [
                        'type' => 'static'
                    ],
                ],
            ],
        ];
        return $entities;
    }
}
