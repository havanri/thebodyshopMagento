<?php
namespace SnaptecHue\Snaptec\Setup;

use Magento\Framework\Setup\{
    ModuleContextInterface,
    ModuleDataSetupInterface,
    InstallDataInterface
};

use Magento\Eav\Setup\EavSetup;
use Magento\Eav\Setup\EavSetupFactory;

class InstallData implements InstallDataInterface
{
    private $eavSetupFactory;

    public function __construct(EavSetupFactory $eavSetupFactory) {
        $this->eavSetupFactory = $eavSetupFactory;
    }

    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        
        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'thumbnail_custom', [
            'type'     => 'varchar',
            'label'    => 'Thumbnail Custom',
            'input'    => 'image',
            'backend'  => 'Magento\Catalog\Model\Category\Attribute\Backend\Image',
            'required' => false,
            'global'   => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group'    => 'Custom Attribute',
        ]);

        $eavSetup->addAttribute(\Magento\Catalog\Model\Category::ENTITY, 'description_custom', [
            'type'     => 'text',
            'label'    => 'Description Custom',
            'input'    => 'textarea',
            'required' => false,
            'global'   => \Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface::SCOPE_STORE,
            'group'    => 'Custom Attribute',
        ]);
        $eavSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'custom_mobile',
            [
                'type' => 'varchar',
                'label' => 'Custom Mobile',
                'input' => 'text',
                'required' => false,
                'visible' => true,
                'system' => false,
                'position' => 100,
                'sort_order' => 100,
                'validate_rules' => '{"max_text_length":40}',
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'is_searchable_in_grid' => true,
                'default' => ''
            ]
        );
        $eavSetup->addAttribute(
            \Magento\Customer\Model\Customer::ENTITY,
            'custom_company',
            [
                'type'         => 'varchar', // attribute with varchar type
                'label'        => 'Custom Company',
                'input'        => 'text',  // attribute input field is text
                'required' => false,
                'visible' => true,
                'system' => false,
                'position' => 101,
                'sort_order' => 101,
                'validate_rules' => '{"max_text_length":40}',
                'is_used_in_grid' => true,
                'is_visible_in_grid' => true,
                'is_filterable_in_grid' => true,
                'is_searchable_in_grid' => true,
                'default' => ''
            ]
        );
    }
}