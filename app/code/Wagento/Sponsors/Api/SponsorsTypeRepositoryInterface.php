<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Api;


interface SponsorsTypeRepositoryInterface
{
    /**
     * Save sponsors type.
     *
     * @param \Wagento\Sponsors\Api\Data\SponsorsTypeInterface $sponsorsType
     * @return \Wagento\Sponsors\Api\Data\SponsorsTypeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Wagento\Sponsors\Api\Data\SponsorsTypeInterface $sponsorsType);

    /**
     * Retrieve sponsors type.
     *
     * @param int $sponsorsTypeId
     * @return \Wagento\Sponsors\Api\Data\SponsorsTypeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($sponsorsTypeId);

    /**
     * Retrieve sponsors type matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Wagento\Sponsors\Api\Data\SponsorsTypeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete sponsors type.
     *
     * @param \Wagento\Sponsors\Api\Data\SponsorsTypeInterface $sponsorsType
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Wagento\Sponsors\Api\Data\SponsorsTypeInterface $sponsorsType);

    /**
     * Delete sponsors type by ID.
     *
     * @param int $sponsorsTypeId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($sponsorsTypeId);
}