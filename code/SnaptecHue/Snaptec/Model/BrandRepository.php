<?php

namespace SnaptecHue\Snaptec\Model;

use SnaptecHue\Snaptec\Model\Brand;
use SnaptecHue\Snaptec\Model\BrandFactory;
use SnaptecHue\Snaptec\Api\Data\BrandInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use SnaptecHue\Snaptec\Api\BrandRepositoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use SnaptecHue\Snaptec\Model\ResourceModel\Brand as BrandResource;
use SnaptecHue\Snaptec\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use SnaptecHue\Snaptec\Api\BrandSearchResultsInterface;

class BrandRepository implements BrandRepositoryInterface
{
    /**
     * @var BrandFactory
     */
    protected $brandFactory;
    /**
     * @var BrandResource
     */
    protected $resource;
    /**
     * @var BrandCollectionFactory
     */
    protected $brandCollection;

    /**
     * @var BrandSearchResultsInterfaceFactory
     */
    protected $searchResults;
    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    public function __construct(
        BrandResource $resource,
        BrandFactory $brandFactory,
        CollectionFactory $collectionFactory,
        BrandSearchResultsInterface $searchResults,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->brandFactory = $brandFactory;
        $this->brandCollection = $collectionFactory;
        $this->searchResults = $searchResults;
        $this->collectionProcessor = $collectionProcessor;
    }
    public function save(BrandInterface $brand)
    {
        try {
            $this->resource->save($brand);
            return $brand;
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $brand;
    }
    public function getById($brandId)
    {
        $brand = $this->brandFactory->create();
        $this->resource->load($brand, $brandId);
        if (!$brand->getId()) {
            throw new NoSuchEntityException(__('Brand with id "%1" does not exist.', $brandId));
        }
        return $brand;
    }

    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var BrandSearchResultsInterface $searchResult */
        $searchResult = $this->searchResults->create();

        $collection = $this->brandCollection->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());
    
        return $searchResult;
    }
    
    public function delete(BrandInterface $brand)
    {
        try {
            $this->resource->delete($brand);
        } catch (\Exception $exception) {
            throw new \Exception(__($exception->getMessage()));
        }
    
        return true;
    }

    public function deleteById($brandId)
    {
        $brand = $this->getById($brandId);
        return $this->delete($brand);
    }
}