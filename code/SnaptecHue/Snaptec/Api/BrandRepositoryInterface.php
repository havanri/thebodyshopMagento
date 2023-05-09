<?php

namespace SnaptecHue\Snaptec\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use SnaptecHue\Snaptec\Api\Data\BrandInterface;

interface BrandRepositoryInterface
{
    /**
     * Save brand.
     *
     * @param \SnaptecHue\Snaptec\Api\Data\BrandInterface $brand
     * @return \SnaptecHue\Snaptec\Api\Data\BrandInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(BrandInterface $brand);

    /**
     * Retrieve brand by id.
     *
     * @param int $id
     * @return \SnaptecHue\Snaptec\Api\Data\BrandInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Retrieve brands matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \SnaptecHue\Snaptec\Api\Data\BrandSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete brand.
     *
     * @param \SnaptecHue\Snaptec\Api\Data\BrandInterface $brand
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(BrandInterface $brand);

    /**
     * Delete brand by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);
}