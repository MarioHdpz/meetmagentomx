<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */

namespace Wagento\AjaxCategory\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Wagento\AjaxCategory\Block\Init;
use Magento\Store\Model\StoreManagerInterface;

class TopmenuBefore implements ObserverInterface
{
    /**
     * @var Init
     */
    private $init;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Topmenu constructor.
     * @param Init $init
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        Init $init,
        StoreManagerInterface $storeManager
    )
    {
        $this->init = $init;
        $this->storeManager = $storeManager;
    }

    /**
     * @param EventObserver $observer
     */
    public function execute(EventObserver $observer)
    {
        $menu = $observer->getEvent()->getMenu();
        foreach ($menu->getChildren() as $child) {
            $catId = preg_replace('/\D/', '', $child->getId());
            $categoryRedirectArray = $this->init->getCategoryRedirect();
            if (!empty($categoryRedirectArray)) {
                $keys = array_keys($categoryRedirectArray);
                if (in_array($catId, $keys)) {
                    $newUrl = $categoryRedirectArray[$catId];
                    $RedirectUrl = $this->storeManager->getStore()->getUrl('') . $newUrl;
                    $child->setUrl($RedirectUrl);
                }
            }
        }
    }
}