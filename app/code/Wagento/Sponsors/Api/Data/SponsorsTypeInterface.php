<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Api\Data;


interface SponsorsTypeInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const SPONSORS_TYPE_ID = 'sponsors_type_id';
    const TITLE = 'title';
    const REQUIRED_SPONSORS = 'required_sponsors';
    const COLUMN = 'column';
    const STATUS = 'status';
    const SORT_ORDER = 'sort_order';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get Sponsors Type Id     *
     * @return int
     */
    public function getSponsorsTypeId();

    /**
     * Set Sponsors Type Id
     * @param $sponsorsTypeId
     */
    public function setSponsorsTypeId($sponsorsTypeId);

    /**
     * Get Sponsor Type Title
     * @return string
     */
    public function getTitle();

    /**
     * Set Sponsor Type Title
     * @param $title
     */
    public function setTitle($title);

    /**
     * Get Required Sponsors
     * @return int
     */
    public function getRequiredSponsors();

    /**
     * Set Required Sponsors
     * @param $requiredSponsors
     */
    public function setRequiredSponsors($requiredSponsors);

    /**
     * Get Sponsor Type Column
     */
    public function getColumn();

    /**
     * Set Sponsor Type Column
     * @param $column
     */
    public function setColumn($column);

    /**
     * Get Sponsors Type Status
     * @return int
     */
    public function getStatus();

    /**
     * Set Sponsors Type Status
     * @param $status
     */
    public function setStatus($status);

    /**
     * Get Sponsors Type SortOrder
     */
    public function getSortOrder();

    /**
     * Set Sponsors Type SortOrder
     * @param $sortOrder
     */
    public function setSortOrder($sortOrder);

    /**
     * Get Sponsors Type CreatedAt
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set Sponsors Type CreatedAt
     * @param $createdAt
     */
    public function setCreatedAt($createdAt);

    /**
     * Get Sponsors Type Updated At
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set Sponsors Type Updated  At
     */
    public function setUpdatedAt($updatedAt);
}