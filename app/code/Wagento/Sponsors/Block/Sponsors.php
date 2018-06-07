<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Block;


use Magento\Framework\Api\SortOrder;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\View\Element\Template;
use Wagento\Sponsors\Api\Data\SponsorsInterface;
use Wagento\Sponsors\Model\Status;
use Wagento\Sponsors\Api\Data\SponsorsTypeInterface;

class Sponsors extends \Wagento\Sponsors\Block\AbstractBlock
{
    /**
     * Sponsors Collection
     */
    protected $_sponsorsTypeCollection;
    /**
     * @var \Wagento\Sponsors\Model\ResourceModel\Sponsors\CollectionFactory
     */
    private $sponsorsCollectionFactory;
    /**
     * @var \Wagento\Sponsors\Model\ResourceModel\SponsorsType\CollectionFactory
     */
    private $sponsorsTypeCollectionFactory;

    /**
     * Sponsors constructor.
     * @param Template\Context $context
     * @param \Wagento\Sponsors\Helper\Data $helper
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param \Wagento\Sponsors\Model\ResourceModel\Sponsors\CollectionFactory $sponsorsCollectionFactory
     * @param \Wagento\Sponsors\Model\ResourceModel\SponsorsType\CollectionFactory $sponsorsTypeCollectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Wagento\Sponsors\Helper\Data $helper,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        \Wagento\Sponsors\Model\ResourceModel\Sponsors\CollectionFactory $sponsorsCollectionFactory,
        \Wagento\Sponsors\Model\ResourceModel\SponsorsType\CollectionFactory $sponsorsTypeCollectionFactory,
        array $data = []
    ){
        parent::__construct($context, $helper, $coreRegistry, $objectManager, $data);
        $this->helper = $helper;
        $this->sponsorsCollectionFactory = $sponsorsCollectionFactory;
        $this->sponsorsTypeCollectionFactory = $sponsorsTypeCollectionFactory;
    }

    /**
     * Retrieve loaded sponsors Type collection
     *
     * @return AbstractCollection
     */
    protected function _getSponsorsTypeCollection()
    {
        if ($this->_sponsorsTypeCollection === null) {
            try {
                $collection = $this->sponsorsTypeCollectionFactory->create();
                $collection->addFieldToFilter(SponsorsTypeInterface::STATUS, ['eq' => Status::ENABLED])
                        ->setOrder(SponsorsTypeInterface::SORT_ORDER, SortOrder::SORT_ASC);

                $this->_sponsorsTypeCollection = $collection;
            } catch (\Exception $e) {

            }
        }
        return $this->_sponsorsTypeCollection;
    }

    /**
     * Retrieve loaded sponsors type collection
     *
     * @return AbstractCollection
     */
    public function getLoadedSponsorsCollection()
    {
        return $this->_getSponsorsTypeCollection();
    }

    /**
     * Retrieve sponsors collection
     *
     * @return AbstractCollection
     */
    public function getSponsorsByTypeCollection($sponsorsTypeId)
    {
        try {
            $collection = $this->sponsorsCollectionFactory->create();
            $collection->addFieldToFilter(SponsorsInterface::STATUS, ['eq' => Status::ENABLED])
                ->addFieldToFilter(SponsorsInterface::SPONSORS_TYPE_ID, ['eq' => $sponsorsTypeId])
                ->setOrder(SponsorsInterface::POSITION, SortOrder::SORT_ASC);

            return $collection;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Need use as _prepareLayout - but problem in declaring collection from
     * another block (was problem with search result)
     * @return $this
     */
    protected function _beforeToHtml()
    {
        $this->_getSponsorsTypeCollection()->load();
        return parent::_beforeToHtml();
    }

    public function getMediaUrl()
    {
        $mediaUrl = $this->_storeManager
            ->getStore()
            ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA );
        return $mediaUrl;
    }
}
