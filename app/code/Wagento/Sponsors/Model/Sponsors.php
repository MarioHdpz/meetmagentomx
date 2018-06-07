<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Model;

use Wagento\Sponsors\Api\Data\SponsorsInterface;

class Sponsors extends \Magento\Framework\Model\AbstractModel implements SponsorsInterface
{

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('Wagento\Sponsors\Model\ResourceModel\Sponsors');
    }

    /**
     * Get Sponsors Id
     * @return int
     */
    public function getSponsorsId()
    {
        return $this->getData(SponsorsInterface::SPONSORS_ID);
    }

    /**
     * Set Sponsors Id
     * @param $sponsorsId
     */
    public function setSponsorsId($sponsorsId)
    {
        return $this->setData(SponsorsInterface::SPONSORS_ID, $sponsorsId);
    }

    /**
     * Get Sponsors Type Id
     * @return int
     */
    public function getSponsorsTypeId()
    {
        return $this->getData(SponsorsInterface::SPONSORS_TYPE_ID);
    }

    /**
     * Set Sponsors Type Id
     * @param $sponsorsTypeId
     */
    public function setSponsorsTypeId($sponsorsTypeId)
    {
        return $this->setData(SponsorsInterface::SPONSORS_TYPE_ID, $sponsorsTypeId);
    }

    /**
     * Get Sponsors Name
     * @return string
     */
    public function getName()
    {
        return $this->getData(SponsorsInterface::NAME);
    }

    /**
     * Set Sponsors Name
     * @param $name
     */
    public function setName($name)
    {
        return $this->setData(SponsorsInterface::NAME, $name);
    }

    /**
     * Get Sponsors Url key
     * @return string
     */
    public function getUrlKey()
    {
        return $this->getData(SponsorsInterface::URL_KEY);
    }

    /**
     * Set Sponsors Url key
     * @param $urlKey
     */
    public function setUrlKey($urlKey)
    {
        return $this->setData(SponsorsInterface::URL_KEY, $urlKey);
    }

    /**
     * Get Sponsors Image
     * @return string
     */
    public function getImage()
    {
        return $this->getData(SponsorsInterface::IMAGE);
    }

    /**
     * Set Sponsors Image
     * @param $image
     */
    public function setImage($image)
    {
        return $this->setData(SponsorsInterface::IMAGE, $image);
    }

    /**
     * Get Sponsors Status
     * @return int
     */
    public function getStatus()
    {
        return $this->getData(SponsorsInterface::STATUS);
    }

    /**
     * Set Sponsors Status
     * @param $status
     */
    public function setStatus($status)
    {
        return $this->setData(SponsorsInterface::STATUS, $status);
    }

    /**
     * Get Sponsors Position
     * @return int
     */
    public function getPosition()
    {
        return $this->getData(SponsorsInterface::POSITION);
    }

    /**
     * Set Sponsors Position
     * @param $position
     */
    public function setPosition($position)
    {
        return $this->setData(SponsorsInterface::POSITION, $position);
    }

    /**
     * Get Sponsors CreatedAt
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData(SponsorsInterface::CREATED_AT);
    }

    /**
     * Set Sponsors CreatedAt
     * @param $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(SponsorsInterface::CREATED_AT, $createdAt);
    }

    /**
     * Get Sponsors Updated At
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->getData(SponsorsInterface::UPDATED_AT);
    }

    /**
     * Set Sponsors Updated  At
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(SponsorsInterface::UPDATED_AT, $updatedAt);
    }
}