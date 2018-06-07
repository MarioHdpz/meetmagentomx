<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Model;

use Wagento\Sponsors\Api\Data\SponsorsTypeInterface;

class SponsorsType extends \Magento\Framework\Model\AbstractModel implements SponsorsTypeInterface
{

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Wagento\Sponsors\Model\ResourceModel\SponsorsType');
    }

    /**
     * Get Sponsors Type Id     *
     * @return int
     */
    public function getSponsorsTypeId()
    {
        return $this->getData(SponsorsTypeInterface::SPONSORS_TYPE_ID);
    }

    /**
     * Set Sponsors Type Id
     * @param $sponsorsTypeId
     */
    public function setSponsorsTypeId($sponsorsTypeId)
    {
        return $this->setData(SponsorsTypeInterface::SPONSORS_TYPE_ID, $sponsorsTypeId);
    }

    /**
     * Get Sponsor Type Title
     * @return string
     */
    public function getTitle()
    {
        return $this->getData(SponsorsTypeInterface::TITLE);
    }

    /**
     * Set Sponsor Type Title
     * @param $title
     */
    public function setTitle($title)
    {
        return $this->setData(SponsorsTypeInterface::TITLE, $title);
    }

    /**
     * Get Required Sponsors
     * @return int
     */
    public function getRequiredSponsors()
    {
        return $this->getData(SponsorsTypeInterface::REQUIRED_SPONSORS);
    }

    /**
     * Set Required Sponsors
     * @param $requiredSponsors
     */
    public function setRequiredSponsors($requiredSponsors)
    {
        return $this->setData(SponsorsTypeInterface::REQUIRED_SPONSORS, $requiredSponsors);
    }

    /**
     * Get Sponsor Type Column
     */
    public function getColumn()
    {
        return $this->getData(SponsorsTypeInterface::COLUMN);
    }

    /**
     * Set Sponsor Type Column
     * @param $column
     */
    public function setColumn($column)
    {
        return $this->setData(SponsorsTypeInterface::COLUMN, $column);
    }

    /**
     * Get Sponsors Type Status
     * @return int
     */
    public function getStatus()
    {
        return $this->getData(SponsorsTypeInterface::STATUS);
    }

    /**
     * Set Sponsors Type Status
     * @param $status
     */
    public function setStatus($status)
    {
        return $this->setData(SponsorsTypeInterface::STATUS, $status);
    }

    /**
     * Get Sponsors Type SortOrder
     */
    public function getSortOrder()
    {
        return $this->getData(SponsorsTypeInterface::SORT_ORDER);
    }

    /**
     * Set Sponsors Type SortOrder
     * @param $sortOrder
     */
    public function setSortOrder($sortOrder)
    {
        return $this->setData(SponsorsTypeInterface::SORT_ORDER, $sortOrder);
    }

    /**
     * Get Sponsors Type CreatedAt
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(SponsorsTypeInterface::CREATED_AT);
    }

    /**
     * Set Sponsors Type CreatedAt
     * @param $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(SponsorsTypeInterface::CREATED_AT, $createdAt);
    }

    /**
     * Get Sponsors Type Updated At
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(SponsorsTypeInterface::UPDATED_AT);
    }

    /**
     * Set Sponsors Type Updated  At
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(SponsorsTypeInterface::UPDATED_AT, $updatedAt);
    }
}