<?php

namespace SnaptecHue\Catalog\Block\Category;

use Magento\Framework\UrlInterface;
use Magento\Catalog\Model\Category\FileInfo;
use Magento\Framework\View\Element\Template;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\LocalizedException;

class CustomCategory extends Template
{

    protected $_categoryFactory;

    private $storeManager;

    private $fileInfo;

    public function __construct(
        Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryFactory,
        UrlInterface $urlBuilder,
        StoreManagerInterface $storeManager,
        FileInfo $fileInfo,
        array $data = []
    ) {
        $this->_categoryFactory = $categoryFactory;
        $this->urlBuilder = $urlBuilder;
        $this->fileInfo = $fileInfo;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    public function getCategories()
    {
        $categories = $this->_categoryFactory->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('include_in_menu', 1)
            ->addAttributeToFilter('parent_id', 2)
            ->addAttributeToFilter('is_active', 1)
            ->addAttributeToSort('sort_order', 'ASC')
            ->setPageSize(5);

        return $categories;
    }
    public function getCategoryImageUrl($category)
    {
        // $store = $this->storeManager->getStore();
        // $imageUrl = $category->getImage();
        // if ($imageUrl) {
        //     $mediaUrl = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        //     $imageUrl = $mediaUrl . $imageUrl;
        //     dd($imageUrl);
        //     return $imageUrl;
        // }
        // return '';
        $url = '';
        $image = $category->getImageUrl();
        if ($image) {
            if (is_string($image)) {
                $store = $this->storeManager->getStore();
                $mediaBaseUrl = $store->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
                if ($this->fileInfo->isBeginsWithMediaDirectoryPath($image)) {
                    $relativePath = $this->fileInfo->getRelativePathToMediaDirectory($image);
                    $url = rtrim($mediaBaseUrl, '/') . '/' . ltrim($relativePath, '/');
                } elseif (substr($image, 0, 1) !== '/') {
                    $url = rtrim($mediaBaseUrl, '/') . '/' . ltrim(FileInfo::ENTITY_MEDIA_PATH, '/') . '/' . $image;
                } else {
                    $url = $image;
                }
            } else {
                throw new LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }
    public function categoryByParentId($parentId)
    {
        $categories = $this->_categoryFactory->create()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('parent_id', $parentId);

        return $categories;
    }
}
