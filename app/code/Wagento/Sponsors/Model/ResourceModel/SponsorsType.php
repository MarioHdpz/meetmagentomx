<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Wagento\Sponsors\Setup\InstallSchema;
use Wagento\Sponsors\Api\Data\SponsorsTypeInterface;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Stdlib\DateTime\DateTime;


class SponsorsType extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    const SPONSORS_TYPE_TABLE = InstallSchema::SPONSORS_TYPES;
    const SPONSORS_TYPE_ID = SponsorsTypeInterface::SPONSORS_TYPE_ID;
    /**
     * @var DateTime
     */
    private $dateTime;

    /**
     * SponsorsType constructor.
     * @param Context $context
     * @param DateTime $dateTime
     * @param null $connectionName
     */
    public function __construct(Context $context, DateTime $dateTime, $connectionName = null)
    {
        parent::__construct($context, $connectionName);
        $this->dateTime = $dateTime;
    }

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(self::SPONSORS_TYPE_TABLE,self::SPONSORS_TYPE_ID);
    }

    /**
     * Set date of last update
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return \Magento\Framework\Model\ResourceModel\Db\AbstractDb
     */
    protected function _beforeSave(AbstractModel $object)
    {
        /* @var $object \Wagento\Sponsors\Model\SponsorsType */
        $date = $this->dateTime->gmtDate();
        if ($object->isObjectNew() && !$object->getCreatedAt()) {
            $object->setCreatedAt($date);
            $object->setUpdatedAt($date);
        } else {
            $object->setUpdatedAt($date);
        }
        return parent::_beforeSave($object);
    }
}