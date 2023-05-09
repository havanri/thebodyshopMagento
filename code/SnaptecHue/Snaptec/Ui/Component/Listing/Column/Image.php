<?php

namespace SnaptecHue\Snaptec\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\Filesystem;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Store\Model\StoreManagerInterface;

class Image extends Column
{
    /**
     * @var Filesystem
     */
    protected $filesystem;
    protected $storeManager;
    /**
     * @var Escaper
     */
    protected $escaper;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Escaper $escaper
     * @param Filesystem $filesystem
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Escaper $escaper,
        Filesystem $filesystem,
        StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        $this->filesystem = $filesystem;
        $this->escaper = $escaper;
        $this->storeManager = $storeManager;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        // $mediaPath = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath();
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            $mediaUrl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) 
            . '/brand/images/';
            foreach ($dataSource['data']['items'] as &$item) {
                if ($item[$fieldName]) {
                    $item[$fieldName . '_src'] = $mediaUrl . $item[$fieldName];
                    // $item[$fieldName . '_alt'] = $this->getAlt($item) ?: '';
                    // $item[$fieldName . '_link'] = $this->getData('config/brand_image/link') ?: false;
                    // $item[$fieldName . '_orig_src'] = $mediaUrl . $item[$fieldName];
                }
            }
        }
        return $dataSource;
    }
    protected function getAlt($row)
    {
        $altField = $this->getData('config/brand_image/altField') ?: 'name';
        return isset($row[$altField]) ? $this->escaper->escapeHtml($row[$altField]) : null;
    }
}
