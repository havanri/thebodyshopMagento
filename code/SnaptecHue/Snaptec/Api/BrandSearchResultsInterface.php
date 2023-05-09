<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace SnaptecHue\Snaptec\Api;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for cms block search results.
 * @api
 * @since 100.0.2
 */
interface BrandSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get blocks list.
     *
     * @return \SnaptecHue\Snaptec\Api\Data\BrandInterface[]
     */
    public function getItems();

    /**
     * Set blocks list.
     *
     * @param \SnaptecHue\Snaptec\Api\Data\BrandInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
