<?php

namespace SnaptecHue\Slider\Api;

/**
 * @api
 */
interface SlideRepositoryInterface
{
    /**
     * Retrieve slide entity.
     * @param int $slideId
     * @return \SnaptecHue\Slider\Api\Data\SlideInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException 
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($slideId);
    /**
     * Save slide.
     * @param \SnaptecHue\Slider\Api\Data\SlideInterface $slide
     * @return \SnaptecHue\Slider\Api\Data\SlideInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\SnaptecHue\Slider\Api\Data\SlideInterface $slide);
    /**
     * Retrieve slides matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\SearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
    /**
     * Delete slide by ID.
     * @param int $slideId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($slideId);
}
