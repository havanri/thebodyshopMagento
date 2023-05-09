<?php

namespace SnaptecHue\Snaptec\Setup;

use Magento\Customer\Model\Customer;
use Magento\Catalog\Setup\CategorySetupFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;

class UpgradeData implements UpgradeDataInterface
{
    private $customerSetupFactory;

    protected $categorySetupFactory;
    public function __construct(
        \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory,
        CategorySetupFactory $categorySetupFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->categorySetupFactory = $categorySetupFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {

        if (version_compare($context->getVersion(), '1.1.0', '<')) {
            $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
            $attributeSetId = $customerSetup->getDefaultAttributeSetId(Customer::ENTITY);
            $attributeGroupId = $customerSetup->getDefaultAttributeGroupId(Customer::ENTITY, $attributeSetId);

            $attribute = $customerSetup->getEavConfig()->getAttribute(
                Customer::ENTITY,
                'custom_mobile'
            );
            $attribute->setData('attribute_set_id', $attributeSetId);
            $attribute->setData('attribute_group_id', $attributeGroupId);
            $attribute->setData(
                'used_in_forms',
                ['adminhtml_customer', 'customer_account_edit', 'customer_account_create']
            );
            $attribute->save();

            //custom_company
            $sampleAttribute = $customerSetup->getEavConfig()->getAttribute(
                Customer::ENTITY,
                'custom_company'
            );
            $sampleAttribute->setData('attribute_set_id', $attributeSetId);
            $sampleAttribute->setData('attribute_group_id', $attributeGroupId);
            $sampleAttribute->setData(
                'used_in_forms',
                ['adminhtml_customer', 'customer_account_edit', 'customer_account_create', 'adminhtml_checkout', 'adminhtml_customer_address', 'customer_register_address', 'checkout_register']
            );
            $sampleAttribute->save();

            //custom attribute category
            $categorySetup = $this->categorySetupFactory->create(['setup' => $setup]);

            $categorySetup->updateAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'description_custom',
                'wysiwyg_enabled',
                true
            );
            $categorySetup->updateAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'description_custom',
                'backend',
                ArrayBackend::class,
            );

            $categorySetup->updateAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'description_custom',
                'is_html_allowed_on_front',
                true
            );

            $categorySetup->updateAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'description_custom',
                'visible',
                true
            );

            $categorySetup->updateAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'description_custom',
                'is_visible_on_front',
                true
            );
            $categorySetup->updateAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'description_custom',
                'is_wysiwyg_enabled',
                true
            );
            $categorySetup->updateAttribute(
                \Magento\Catalog\Model\Category::ENTITY,
                'description_custom',
                'is_pagebuilder_enabled',
                true
            );
        }
        $setup->endSetup();
    }
}
