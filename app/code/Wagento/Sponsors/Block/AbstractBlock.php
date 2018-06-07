<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Block;

use Magento\Framework\View\Element\Template;

class AbstractBlock extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Wagento\Sponsors\Helper\Data
     */
    public $helper;
    /**
     * @var \Magento\Framework\Registry
     */
    public $coreRegistry;
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    public $objectManager;

    /**
     * AbstractBlock constructor.
     * @param Template\Context $context
     * @param \Wagento\Sponsors\Helper\Data $helper
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        \Wagento\Sponsors\Helper\Data $helper,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\ObjectManagerInterface $objectManager,
        array $data = [])
    {
        parent::__construct($context, $data);
        $this->helper = $helper;
        $this->coreRegistry = $coreRegistry;
        $this->objectManager = $objectManager;
    }

    /**
     * @return \Wagento\Sponsors\Helper\Data
     */
    public function getHelper()
    {
        return $this->helper;
    }

    /**
     * @return \Magento\Store\Model\StoreManagerInterface
     */
    public function storeManager()
    {
        return $this->_storeManager;
    }


    /**
     * @return \Magento\Framework\ObjectManagerInterface
     */
    public function getObjectManager()
    {
        return $this->objectManager;
    }
}
