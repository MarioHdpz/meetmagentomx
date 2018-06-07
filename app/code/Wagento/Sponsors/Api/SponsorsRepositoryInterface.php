<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Api;


interface SponsorsRepositoryInterface
{
    /**
     * Save sponsors.
     *
     * @param \Wagento\Sponsors\Api\Data\SponsorsInterface $sponsors
     * @return \Wagento\Sponsors\Api\Data\SponsorsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Wagento\Sponsors\Api\Data\SponsorsInterface $sponsors);

    /**
     * Retrieve sponsors.
     *
     * @param int $sponsorsId
     * @return \Wagento\Sponsors\Api\Data\SponsorsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($sponsorsId);

    /**
     * Retrieve sponsors matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Wagento\Sponsors\Api\Data\SponsorsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete sponsors.
     *
     * @param \Wagento\Sponsors\Api\Data\SponsorsInterface $sponsors
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Wagento\Sponsors\Api\Data\SponsorsInterface $sponsors);

    /**
     * Delete sponsors by ID.
     *
     * @param int $sponsorsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($sponsorsId);
}