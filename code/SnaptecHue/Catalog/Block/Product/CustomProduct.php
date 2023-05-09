<?php

namespace SnaptecHue\Catalog\Block\Product;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\LocalizedException;

class CustomProduct extends Template
{

    protected $_productFactory;

    private $storeManager;

    private const IMAGE_INFO = "/catalog/product";


    public function __construct(
        Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productFactory,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->_productFactory = $productFactory;
        $this->urlBuilder = $urlBuilder;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    public function getNewProducts()
    {
        $products = $this->_productFactory->create()
        ->addAttributeToSelect('*')
        ->setPageSize(10)
        ->addAttributeToSort('sort_order', 'ASC')
        ->load();

        return $products;
    }
}
