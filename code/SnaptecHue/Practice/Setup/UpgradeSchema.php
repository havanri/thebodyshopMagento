<?php

namespace SnaptecHue\Practice\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {

        $setup->startSetup();

        if (version_compare($context->getVersion(), '1.1.0', '<')) {

            $employeeEntityTable = \SnaptecHue\Practice\Model\Employee::ENTITY . '_entity';
            $departmentEntityTable = 'snaptechue_practice_department';

            $setup->getConnection()
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntityTable,
                        'department_id',
                        $departmentEntityTable,
                        'entity_id'
                    ),
                    $setup->getTable($employeeEntityTable),
                    'department_id',
                    $setup->getTable($departmentEntityTable),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                );
        }


        $setup->endSetup();
    }
}
