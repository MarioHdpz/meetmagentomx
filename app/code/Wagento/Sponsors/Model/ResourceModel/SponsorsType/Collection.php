<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Model\ResourceModel\SponsorsType;
use Wagento\Sponsors\Api\Data\SponsorsTypeInterface;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = SponsorsTypeInterface::SPONSORS_TYPE_ID;
    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init('Wagento\Sponsors\Model\SponsorsType', 'Wagento\Sponsors\Model\ResourceModel\SponsorsType');
    }
}