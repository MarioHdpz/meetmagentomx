<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\AjaxCategory\Helper;

use Magento\Store\Model\StoreManagerInterface;
use Wagento\AjaxCategory\Block\Init;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
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
     * Data constructor.
     * @param \Magento\Framework\App\Helper\Context $context
     * @param Init $init
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(\Magento\Framework\App\Helper\Context $context,Init $init, StoreManagerInterface $storeManager)
    {
        parent::__construct($context);
        $this->init = $init;
        $this->storeManager = $storeManager;
    }

    public function getCategory($product)
    {
        try {
            $productCategory = [];
            $storeUrl = $this->storeManager->getStore()->getUrl('store');
            $catCollection = $product->getCategoryCollection()->addAttributeToSelect('name');
            foreach ($catCollection as $cat) {
                if($cat->getId() == $this->init->getScrollConfig('general/default_category')){
                    continue;
                }
                $productCategory['url'] = $storeUrl . '?catalog=' . $cat->getId();
                $productCategory['name'] = $cat->getName();
            }
            return $productCategory;
        }catch (\Exception $exception){
            return $productCategory;
        }
    }
}
