<?php

namespace SnaptecHue\Practice\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{

    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.1.0', '<')) {
            $setup->startSetup();

            /* #create Department Table */
            $table = $setup->getConnection()
                ->newTable($setup->getTable('snaptechue_practice_department'))
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'Entity ID'
                )
                ->addColumn(
                    'name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    64,
                    [],
                    'Name'
                )
                ->setComment('SnaptecHue Practice Department Table');
            $setup->getConnection()->createTable($table);

            /* #create Employee Table */
            $employeeEntity = \SnaptecHue\Practice\Model\Employee::ENTITY;
            $table = $setup->getConnection()
                ->newTable($setup->getTable($employeeEntity . '_entity'))
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'primary' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'identity' => true
                    ],
                    'Entity ID'
                )
                ->addColumn(
                    'department_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false
                    ],
                    'Department ID'
                )
                ->addColumn(
                    'email',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    64,
                    [],
                    'Email'
                )->addColumn(
                    'first_name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    64,
                    [],
                    'First Name'
                )->addColumn(
                    'last_name',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    64,
                    [],
                    'Last Name'
                )
                ->setComment('SnaptecHue Practice Employee Table');
            $setup->getConnection()->createTable($table);

            /* ---- create  EAV attribute data type(s) ---- */

            /*foggyline_office_employee_entity_decimal */
            $table = $setup->getConnection()
                ->newTable($setup->getTable($employeeEntity . '_entity_decimal'))
                ->addColumn(
                    'value_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'primary' => true,
                        // 'unsigned'=>true,
                        'identity' => true,
                        'nullable' => false
                    ],
                    'Value ID'
                )
                ->addColumn(
                    'attribute_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Attribute ID'
                )
                ->addColumn(
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Store ID'
                )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Entity ID'
                )
                ->addColumn(
                    'value',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DECIMAL,
                    '12,4',
                    [],
                    'Value'
                )
                //->addIndex
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_decimal',
                        ['entity_id', 'attribute_id', 'store_id'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['entity_id', 'attribute_id', 'store_id'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_decimal',
                        ['store_id']
                    ),
                    ['store_id']
                )
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_decimal',
                        ['attribute_id']
                    ),
                    ['attribute_id']
                )
                //->addForeignKey
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_decimal',
                        'attribute_id',
                        'eav_attribute',
                        'attribute_id'
                    ),
                    'attribute_id',
                    $setup->getTable('eav_attribute'),
                    'attribute_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_decimal',
                        'entity_id',
                        $employeeEntity . '_entity',
                        'entity_id'
                    ),
                    'entity_id',
                    $setup->getTable($employeeEntity . '_entity'),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_decimal',
                        'store_id',
                        'store',
                        'store_id'
                    ),
                    'store_id',
                    $setup->getTable('store'),
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->setComment('Employee Decimal Attribute Backend Table');
            $setup->getConnection()->createTable($table);
            /*foggyline_office_employee_entity_int*/
            $table = $setup->getConnection()
                ->newTable($setup->getTable($employeeEntity . '_entity_int'))
                ->addColumn(
                    'value_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'primary' => true,
                        // 'unsigned'=>true,
                        'identity' => true,
                        'nullable' => false
                    ],
                    'Value ID'
                )
                ->addColumn(
                    'attribute_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Attribute ID'
                )
                ->addColumn(
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Store ID'
                )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Entity ID'
                )
                ->addColumn(
                    'value',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [],
                    'Value'
                )
                //->addIndex
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_int',
                        ['entity_id', 'attribute_id', 'store_id'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['entity_id', 'attribute_id', 'store_id'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_int',
                        ['store_id']
                    ),
                    ['store_id']
                )
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_int',
                        ['attribute_id']
                    ),
                    ['attribute_id']
                )
                //->addForeignKey
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_int',
                        'attribute_id',
                        'eav_attribute',
                        'attribute_id'
                    ),
                    'attribute_id',
                    $setup->getTable('eav_attribute'),
                    'attribute_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_int',
                        'entity_id',
                        $employeeEntity . '_entity',
                        'entity_id'
                    ),
                    'entity_id',
                    $setup->getTable($employeeEntity . '_entity'),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_int',
                        'store_id',
                        'store',
                        'store_id'
                    ),
                    'store_id',
                    $setup->getTable('store'),
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->setComment('Employee Integer Attribute Backend Table');
            $setup->getConnection()->createTable($table);
            /*foggyline_office_employee_entity_text */
            $table = $setup->getConnection()
                ->newTable($setup->getTable($employeeEntity . '_entity_text'))
                ->addColumn(
                    'value_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'primary' => true,
                        // 'unsigned'=>true,
                        'identity' => true,
                        'nullable' => false
                    ],
                    'Value ID'
                )
                ->addColumn(
                    'attribute_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Attribute ID'
                )
                ->addColumn(
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Store ID'
                )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Entity ID'
                )
                ->addColumn(
                    'value',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    null,
                    [],
                    'Value'
                )
                //->addIndex
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_int',
                        ['entity_id', 'attribute_id', 'store_id'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['entity_id', 'attribute_id', 'store_id'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_text',
                        ['store_id']
                    ),
                    ['store_id']
                )
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_text',
                        ['attribute_id']
                    ),
                    ['attribute_id']
                )
                //->addForeignKey
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_text',
                        'attribute_id',
                        'eav_attribute',
                        'attribute_id'
                    ),
                    'attribute_id',
                    $setup->getTable('eav_attribute'),
                    'attribute_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_text',
                        'entity_id',
                        $employeeEntity . '_entity',
                        'entity_id'
                    ),
                    'entity_id',
                    $setup->getTable($employeeEntity . '_entity'),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_text',
                        'store_id',
                        'store',
                        'store_id'
                    ),
                    'store_id',
                    $setup->getTable('store'),
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->setComment('Employee Text Attribute Backend Table');
            $setup->getConnection()->createTable($table);
            /*foggyline_office_employee_entity_varchar */
            $table = $setup->getConnection()
                ->newTable($setup->getTable($employeeEntity . '_entity_varchar'))
                ->addColumn(
                    'value_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'primary' => true,
                        // 'unsigned'=>true,
                        'identity' => true,
                        'nullable' => false
                    ],
                    'Value ID'
                )
                ->addColumn(
                    'attribute_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Attribute ID'
                )
                ->addColumn(
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Store ID'
                )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Entity ID'
                )
                ->addColumn(
                    'value',
                    \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    255,
                    [],
                    'Value'
                )
                //->addIndex
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_int',
                        ['entity_id', 'attribute_id', 'store_id'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['entity_id', 'attribute_id', 'store_id'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_varchar',
                        ['store_id']
                    ),
                    ['store_id']
                )
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_varchar',
                        ['attribute_id']
                    ),
                    ['attribute_id']
                )
                //->addForeignKey
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_varchar',
                        'attribute_id',
                        'eav_attribute',
                        'attribute_id'
                    ),
                    'attribute_id',
                    $setup->getTable('eav_attribute'),
                    'attribute_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_varchar',
                        'entity_id',
                        $employeeEntity . '_entity',
                        'entity_id'
                    ),
                    'entity_id',
                    $setup->getTable($employeeEntity . '_entity'),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_varchar',
                        'store_id',
                        'store',
                        'store_id'
                    ),
                    'store_id',
                    $setup->getTable('store'),
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->setComment('Employee Varchar Attribute Backend Table');
            $setup->getConnection()->createTable($table);
            /*foggyline_office_employee_entity_datetime */
            $table = $setup->getConnection()
                ->newTable($setup->getTable($employeeEntity . '_entity_datetime'))
                ->addColumn(
                    'value_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'primary' => true,
                        // 'unsigned'=>true,
                        'identity' => true,
                        'nullable' => false
                    ],
                    'Value ID'
                )
                ->addColumn(
                    'attribute_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Attribute ID'
                )
                ->addColumn(
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Store ID'
                )
                ->addColumn(
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                    null,
                    [
                        'unsigned' => true,
                        'nullable' => false,
                        'default' => '0'
                    ],
                    'Entity ID'
                )
                ->addColumn(
                    'value',
                    \Magento\Framework\DB\Ddl\Table::TYPE_DATETIME,
                    255,
                    [],
                    'Value'
                )
                //->addIndex
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_int',
                        ['entity_id', 'attribute_id', 'store_id'],
                        \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE
                    ),
                    ['entity_id', 'attribute_id', 'store_id'],
                    ['type' => \Magento\Framework\DB\Adapter\AdapterInterface::INDEX_TYPE_UNIQUE]
                )
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_datetime',
                        ['store_id']
                    ),
                    ['store_id']
                )
                ->addIndex(
                    $setup->getIdxName(
                        $employeeEntity . '_entity_datetime',
                        ['attribute_id']
                    ),
                    ['attribute_id']
                )
                //->addForeignKey
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_datetime',
                        'attribute_id',
                        'eav_attribute',
                        'attribute_id'
                    ),
                    'attribute_id',
                    $setup->getTable('eav_attribute'),
                    'attribute_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_datetime',
                        'entity_id',
                        $employeeEntity . '_entity',
                        'entity_id'
                    ),
                    'entity_id',
                    $setup->getTable($employeeEntity . '_entity'),
                    'entity_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->addForeignKey(
                    $setup->getFkName(
                        $employeeEntity . '_entity_datetime',
                        'store_id',
                        'store',
                        'store_id'
                    ),
                    'store_id',
                    $setup->getTable('store'),
                    'store_id',
                    \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
                )
                ->setComment('Employee Datetime Attribute Backend Table');
            $setup->getConnection()->createTable($table);

            $setup->endSetup();
        }
    }
}
