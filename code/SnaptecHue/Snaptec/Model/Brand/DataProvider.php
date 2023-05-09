<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace SnaptecHue\Snaptec\Model\Brand;

use Psr\Log\LoggerInterface;
use Magento\Cms\Model\PageFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\RequestInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\AuthorizationInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Magento\Ui\DataProvider\ModifierPoolDataProvider;
use Magento\Framework\App\Request\DataPersistorInterface;
use SnaptecHue\Snaptec\Model\ResourceModel\Brand\CollectionFactory;

/**
 * Cms Page DataProvider
 */
class DataProvider extends ModifierPoolDataProvider
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;


    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var AuthorizationInterface
     */
    private $auth;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var PageFactory
     */
    private $pageFactory;

    /**
     * @var LoggerInterface
     */

    private $logger;
    /**
     * @var StoreManagerInterface
     */
    protected $collection;
    protected $storageManager;
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $brandCollectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storageManager,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null,
        ?AuthorizationInterface $auth = null,
        ?RequestInterface $request = null,
        ?LoggerInterface $logger = null
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
        $this->collection = $brandCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storageManager = $storageManager;
        $this->meta = $this->prepareMeta($this->meta);
        $this->auth = $auth ?? ObjectManager::getInstance()->get(AuthorizationInterface::class);
        $this->request = $request ?? ObjectManager::getInstance()->get(RequestInterface::class);
        $this->logger = $logger ?: ObjectManager::getInstance()->get(LoggerInterface::class);
    }

    /**
     * Prepares Meta
     *
     * @param array $meta
     * @return array
     */
    public function prepareMeta(array $meta)
    {
        return $meta;
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $brand) {
            $data = $brand->getData();
            $image = $data['image'];
            if ($image && is_string($image)) {
                $data['images'][0]['name'] = $image;
                $data['images'][0]['url'] = $this->storageManager->getStore()
                        ->getBaseUrl(UrlInterface::URL_TYPE_MEDIA)
                    . 'brand/images/' . $image;
            }

            $this->loadedData[$brand->getId()] = $data;
        }
        // foreach ($items as $item) {
        //     $this->loadedData[$item->getId()] = $item->getData();
        //     $image = $item['image'];
        //     $item['images'][0]['url'] = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'brand/images' . $image;
        //     $item['images'][0]['name'] = $image;
        // }

        $data = $this->dataPersistor->get('snaptechue_snaptec_brand');
        if (!empty($data)) {
            $brand = $this->collection->getNewEmptyItem();
            $brand->setData($data);
            $this->loadedData[$brand->getId()] = $brand->getData();
            $this->dataPersistor->clear('snaptechue_snaptec_brand');
        }
        return $this->loadedData;
    }
}
