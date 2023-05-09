<?php

namespace SnaptecHue\Slider\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;

class SlideRepository implements \SnaptecHue\Slider\Api\SlideRepositoryInterface
{
    /**
     * @var \SnaptecHue\Slider\Model\ResourceModel\Slide
     */
    protected $resource;
    /**
     * @var \SnaptecHue\Slider\Model\SlideFactory
     */
    protected $slideFactory;
    /**
     * @var \SnaptecHue\Slider\Model\ResourceModel\Slide\ CollectionFactory
     */
    protected $slideCollectionFactory;
    /**
     * @var \Magento\Framework\Api\SearchResultsInterface
     */
    protected $searchResultsFactory;
    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;
    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;
    /**
     * @var \SnaptecHue\Slider\Api\Data\SlideInterfaceFactory
     */
    protected $dataSlideFactory;
    /**
     * @param ResourceModel\Slide $resource
     * @param SlideFactory $slideFactory
     * @param ResourceModel\Slide\CollectionFactory $slideCollectionFactory
     * @param \Magento\Framework\Api\SearchResultsInterface $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param \SnaptecHue\Slider\Api\Data\SlideInterfaceFactory $dataSlideFactory
     */
    public function __construct(
        \SnaptecHue\Slider\Model\ResourceModel\Slide $resource,
        \SnaptecHue\Slider\Model\SlideFactory $slideFactory,
        \SnaptecHue\Slider\Model\ResourceModel\Slide\CollectionFactory $slideCollectionFactory,
        \Magento\Framework\Api\SearchResultsInterface $searchResultsFactory,
        \Magento\Framework\Api\DataObjectHelper $dataObjectHelper,
        \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor,
        \SnaptecHue\Slider\Api\Data\SlideInterfaceFactory $dataSlideFactory
    ) {
        $this->resource = $resource;
        $this->slideFactory = $slideFactory;
        $this->slideCollectionFactory = $slideCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataSlideFactory = $dataSlideFactory;
    }

    /**
     * Retrieve slide entity.
     *
     * @api
     * @param int $slideId
     * @return \SnaptecHue\Slider\Api\Data\SlideInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException If slide with the specified ID does not exist.
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($slideId)
    {
        $slide = $this->slideFactory->create();
        $this->resource->load($slide, $slideId);
        if (!$slide->getId()) {
            throw new NoSuchEntityException(__('Slide with id %1 does not exist.', $slideId));
        }
        return $slide;
    }
    /**
     * Save slide.
     *
     * @param \SnaptecHue\Slider\Api\Data\SlideInterface $slide
     * @return \SnaptecHue\Slider\Api\Data\SlideInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\SnaptecHue\Slider\Api\Data\SlideInterface $slide)
    {
        try {
            $this->resource->save($slide);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $slide;
    }
    /**
     * Retrieve slides matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $this->searchResultsFactory->setSearchCriteria($searchCriteria);
        $collection = $this->slideCollectionFactory->create();
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter(
                    $filter->getField(),
                    [$condition => $filter->getValue()]
                );
            }
        }
        $this->searchResultsFactory->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    (strtoupper($sortOrder->getDirection()) === 'ASC')
                        ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());
        $slides = [];
        /** @var \SnaptecHue\Slider\Model\Slide $slideModel */
        foreach ($collection as $slideModel) {
            $slideData = $this->dataSlideFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $slideData,
                $slideModel->getData(),
                '\SnaptecHue\Slider\Api\Data\SlideInterface'
            );
            $slides[] = $this->dataObjectProcessor->buildOutputDataArray(
                $slideData,
                '\SnaptecHue\Slider\Api\Data\SlideInterface'
            );
        }
        $this->searchResultsFactory->setItems($slides);
        return $this->searchResultsFactory;
    }
    /**
     * Delete Slide
     *
     * @param \SnaptecHue\Slider\Api\Data\SlideInterface $slide
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(\SnaptecHue\Slider\Api\Data\SlideInterface $slide)
    {
        try {
            $this->resource->delete($slide);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }
    /**
     * Delete slide by ID.
     *
     * @param int $slideId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($slideId)
    {
        return $this->delete($this->getById($slideId));
    }
}
