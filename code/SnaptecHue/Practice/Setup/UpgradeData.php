<?php

namespace SnaptecHue\Practice\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

class UpgradeData implements UpgradeDataInterface
{
    protected $departmentFactory;
    protected $employeeFactory;
    public function __construct(
        \SnaptecHue\Practice\Model\DepartmentFactory $departmentFactory,
        \SnaptecHue\Practice\Model\EmployeeFactory $employeeFactory
    ) {
        $this->departmentFactory = $departmentFactory;
        $this->employeeFactory = $employeeFactory;
    }
    public function upgrade(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        
        $salesDepartment = $this->departmentFactory->create();
        $salesDepartment->setName('Sales');
        $salesDepartment->save();

        $employee = $this->employeeFactory->create();
        $employee->setDepartmentId($salesDepartment->getId());
        $employee->setEmail('john@sales.loc');
        $employee->setFirstName('John');
        $employee->setLastName('Doe');
        $employee->setServiceYears(3);
        $employee->setDob('1983-03-28');
        $employee->setSalary(3800.00);
        $employee->setVatNumber('GB123456789');
        $employee->setNote('Just some notes about John');
        $employee->save();

        $setup->endSetup();
    }
}
