<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Api\Data;


use Magento\Framework\Api\SearchResultsInterface;

interface SponsorsSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get sponsors list.
     *
     * @return \Wagento\Sponsors\Api\Data\SponsorsInterface[]
     */
    public function getItems();

    /**
     * Set sponsors list.
     *
     * @param \Wagento\Sponsors\Api\Data\SponsorsInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}