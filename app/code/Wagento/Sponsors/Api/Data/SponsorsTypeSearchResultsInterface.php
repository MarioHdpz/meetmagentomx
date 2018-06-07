<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Api\Data;


use Magento\Framework\Api\SearchResultsInterface;

interface SponsorsTypeSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get sponsors type list.
     *
     * @return \Wagento\Sponsors\Api\Data\SponsorsTypeInterface[]
     */
    public function getItems();

    /**
     * Set sponsors type list.
     *
     * @param \Wagento\Sponsors\Api\Data\SponsorsTypeInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}