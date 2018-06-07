<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */

namespace Wagento\AjaxCategory\Block;

use Magento\Catalog\Api\CategoryRepositoryInterface;

class Init extends \Magento\Framework\View\Element\Template
{

    private $scopeConfig;
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;
    /**
     * Init constructor.
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param CategoryRepositoryInterface $categoryRepository
     * @param array $data
     * @internal param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        CategoryRepositoryInterface $categoryRepository,
        array $data = []
    ) {
        $this->scopeConfig = $context->getScopeConfig();
        $this->categoryRepository = $categoryRepository;
        parent::__construct($context, $data);
    }

    /**
     * check current device is mobile or desktop
     */

    /**
     * @param $fullPath
     * @return mixed
     */
    public function getConfig($fullPath)
    {
        return $this->scopeConfig->getValue($fullPath, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @param $node
     * @return mixed
     */
    public function getScrollConfig($node)
    {
        return $this->getConfig('ajaxcategory/' . $node);
    }



    /**
     *  check category redirect enabled
     */
    public function isCategoryRedirectEnabled() {
        return $this->getScrollConfig('category/enabled');
    }

    /**
     * @return array
     */
    public function getCategoryRedirect() {
        $categoryRedirectArray = array();
        $categoryRedirect = $this->getScrollConfig('category/category_redirect');
        if($this->isCategoryRedirectEnabled() && $categoryRedirect) {
            $categoryRedirect = unserialize($categoryRedirect);
            foreach ($categoryRedirect as $value) {
                $categoryRedirectArray[$value['cat_id']] = $value['redirect_url'];
            }
        }
        return $categoryRedirectArray;
    }

}
