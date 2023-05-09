<?php

namespace SnaptecHue\Snaptec\Block;

use Magento\Framework\View\Element\Template;
use SnaptecHue\Snaptec\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
class Brand extends Template
{
    protected $brandCollectionFactory;
    public $brand_list;
    public function __construct(
        Template\Context $context,
        CollectionFactory $brandCollectionFactory,
        array $data = [],
    ) {   
        $this->brandCollectionFactory = $brandCollectionFactory;
        parent::__construct($context, $data);
        $this->setTemplate('brands.phtml');
    }

    public function getBrands()
    {
        $brands = $this->brandCollectionFactory->create();
        $brands->getData();
        return $brands;
    }
    

}