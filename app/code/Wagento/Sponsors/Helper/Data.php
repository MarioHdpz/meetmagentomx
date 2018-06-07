<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\App\Helper\Context;

/**
 * Sponsors Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Data constructor.
     * @param Context $context
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ){
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    /**
     * @param $path
     * @param string $scopeType
     * @param null $store
     *
     * @return mixed
     */
    public function getConfig($path, $scopeType = ScopeInterface::SCOPE_STORE, $store = null)
    {
        if ($store == null) {
            $store = $this->storeManager->getStore()->getId();
        }

        return $this->scopeConfig->getValue(
            $path,
            $scopeType,
            $store
        );
    }

    /**
     * Check enable frontend.
     *
     * @return mixed
     */
    public function isEnable()
    {
        return $this->getConfig('sponsors/general/enabled');
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->getConfig('sponsors/general/headline');
    }

    /**
     * @return mixed
     */
    public function getPlaceholderImage()
    {
        return $this->getConfig('sponsors/general/placeholder');
    }

    /**
     * @return mixed
     */
    public function showTopLink()
    {
        return $this->getConfig('sponsors/toplink/enabled');
    }

    /**
     * @return mixed
     */
    public function getTopLinkTitle()
    {
        return $this->getConfig('sponsors/toplink/title');
    }

    /**
     * @return mixed
     */
    public function showMenuBar()
    {
        return $this->getConfig('sponsors/topmenu/enabled');
    }

    /**
     * @return mixed
     */
    public function getMenuTitle()
    {
        return $this->getConfig('sponsors/topmenu/title');
    }

    /**
     * @return mixed
     */
    public function getMenuPosition()
    {
        return (int)$this->getConfig('sponsors/topmenu/position');
    }

    /**
     * @return mixed
     */
    public function getFrontendUrlPath()
    {
        return $this->getConfig('sponsors/topmenu/frontend_url_path');
    }
}
