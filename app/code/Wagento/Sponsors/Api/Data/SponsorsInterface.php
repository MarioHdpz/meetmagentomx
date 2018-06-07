<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Api\Data;


interface SponsorsInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const SPONSORS_ID = 'sponsors_id';
    const SPONSORS_TYPE_ID = 'sponsors_type_id';
    const NAME = 'name';
    const URL_KEY = 'url_key';
    const IMAGE = 'image';
    const STATUS = 'status';
    const POSITION = 'position';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * Get Sponsors Id
     * @return int
     */
    public function getSponsorsId();

    /**
     * Set Sponsors Id
     * @param $sponsorsId
     */
    public function setSponsorsId($sponsorsId);

    /**
     * Get Sponsors Type Id
     * @return int
     */
    public function getSponsorsTypeId();

    /**
     * Set Sponsors Type Id
     * @param $sponsorsTypeId
     */
    public function setSponsorsTypeId($sponsorsTypeId);

    /**
     * Get Sponsors Name
     * @return string
     */
    public function getName();

    /**
     * Set Sponsors Name
     * @param $name
     */
    public function setName($name);

    /**
     * Get Sponsors Url key
     * @return string
     */
    public function getUrlKey();

    /**
     * Set Sponsors Url key
     * @param $urlKey
     */
    public function setUrlKey($urlKey);

    /**
     * Get Sponsors Image
     * @return string
     */
    public function getImage();

    /**
     * Set Sponsors Image
     * @param $image
     */
    public function setImage($image);

    /**
     * Get Sponsors Status
     * @return int
     */
    public function getStatus();

    /**
     * Set Sponsors Status
     * @param $status
     */
    public function setStatus($status);

    /**
     * Get Sponsors Position
     * @return int
     */
    public function getPosition();

    /**
     * Set Sponsors Position
     * @param $position
     */
    public function setPosition($position);

    /**
     * Get Sponsors CreatedAt
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set Sponsors CreatedAt
     * @param $createdAt
     */
    public function setCreatedAt($createdAt);

    /**
     * Get Sponsors Updated At
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set Sponsors Updated  At
     */
    public function setUpdatedAt($updatedAt);
}