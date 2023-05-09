<?php
namespace SnaptecHue\BestSeller\Block\Product;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\View\Element\Template\Context;
use Magento\Sales\Model\ResourceModel\Report\Bestsellers\CollectionFactory as BestsellersCollectionFactory;

class Bestsellers extends \Magento\Framework\View\Element\Template
{
    protected $_bestsellersCollectionFactory;
    protected $_collectionFactory;

    public function __construct(
        Context $context,
        BestsellersCollectionFactory $bestsellersCollectionFactory,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        $this->_bestsellersCollectionFactory = $bestsellersCollectionFactory;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $data);
    }

    public function getBestSellersProducts($limit = 10)
    {
        $bestsellersCollection = $this->_bestsellersCollectionFactory->create();
        $bestsellersCollection->setPageSize($limit);

        $productIds = [];

        foreach ($bestsellersCollection as $product) {
            $productIds[] = $product->getProductId();
        }

        $productCollection = $this->_collectionFactory->create();
        $productCollection->addAttributeToSelect('*');
        $productCollection->addIdFilter($productIds);
        return $productCollection;
    }
}