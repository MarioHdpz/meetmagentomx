<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Model\ResourceModel\Sponsors;
use Wagento\Sponsors\Api\Data\SponsorsInterface;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = SponsorsInterface::SPONSORS_ID;

    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Wagento\Sponsors\Model\Sponsors', 'Wagento\Sponsors\Model\ResourceModel\Sponsors');
    }
}