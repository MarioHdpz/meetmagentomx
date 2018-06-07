<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Observer;

use Magento\Framework\Event\ObserverInterface;

class AddToTopMenu implements ObserverInterface
{
    /**
     * @var \Magento\Catalog\Helper\Category
     */
    protected $catalogCategory;
    /**
     * @var \Magento\Catalog\Model\Indexer\Category\Flat\State
     */
    protected $categoryFlatState;
    /**
     * @var \Magento\Catalog\Observer\MenuCategoryData
     */
    protected $menuCategoryData;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var \Wagento\Sponsors\Helper\Data
     */
    private $helperSponsors;

    /**
     * AddToTopMenu constructor.
     * @param \Magento\Catalog\Helper\Category $catalogCategory
     * @param \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState
     * @param \Magento\Catalog\Observer\MenuCategoryData $menuCategoryData
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Wagento\Sponsors\Helper\Data $helperSponsors
     */
    public function __construct(
        \Magento\Catalog\Helper\Category $catalogCategory,
        \Magento\Catalog\Model\Indexer\Category\Flat\State $categoryFlatState,
        \Magento\Catalog\Observer\MenuCategoryData $menuCategoryData,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Wagento\Sponsors\Helper\Data $helperSponsors
    ) {
        $this->catalogCategory = $catalogCategory;
        $this->categoryFlatState = $categoryFlatState;
        $this->menuCategoryData = $menuCategoryData;
        $this->storeManager = $storeManager;
        $this->helperSponsors = $helperSponsors;
    }

    /**
     * Checking whether the using static urls in WYSIWYG allowed event
     *
     * @param \Magento\Framework\Event\Observer $observer
     *
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /*configuration info*/
        $sponsorsEnable = $this->helperSponsors->isEnable();
        $sponsorsMenuTitle = $this->helperSponsors->getMenuTitle();
        $sponsorsMenuPosition = ($this->helperSponsors->getMenuPosition()) ? $this->helperSponsors->getMenuPosition() : 1;
        $sponsorsUrl = ($this->helperSponsors->getFrontendUrlPath()) ?  $this->storeManager->getStore()->getUrl($this->helperSponsors->getFrontendUrlPath()) : '';

        /*add to top menu*/
        $block = $observer->getEvent()->getBlock();
        $block->addIdentity(\Magento\Catalog\Model\Category::CACHE_TAG);
        $this->_addCategoriesToMenu($this->catalogCategory->getStoreCategories(), $observer->getMenu(), $block);
        if ($sponsorsEnable && $sponsorsMenuTitle && $sponsorsUrl) {

            $sponsorsData = [
                'name'       => $sponsorsMenuTitle,
                'id'         => 'sponsors',
                'url'        => $sponsorsUrl,
                'has_active' => false,
                'is_active'  => false,
            ];

            $parentCategoryNode = $observer->getMenu();
            $tree = $parentCategoryNode->getTree();
            $categoryNode = new \Magento\Framework\Data\Tree\Node($sponsorsData, 'id', $tree, $parentCategoryNode);

            $menuItems = array();
            $i = 1;
            foreach ($parentCategoryNode->getChildren() as $child){
                if($i == $sponsorsMenuPosition) {
                    $menuItems[] = $categoryNode;
                }
                $menuItems[] = $child;
                $parentCategoryNode->removeChild($child);
                $i++;
            }
            if($sponsorsMenuPosition >= count($parentCategoryNode->getChildren())){
                $menuItems[] = $categoryNode;
            }
            foreach ($menuItems as $child){
                $parentCategoryNode->addChild($child);
            }
        }
    }

    /**
     * Recursively adds categories to top menu
     *
     * @param \Magento\Framework\Data\Tree\Node\Collection|array $categories
     * @param \Magento\Framework\Data\Tree\Node $parentCategoryNode
     * @param \Magento\Theme\Block\Html\Topmenu $block
     *
     * @return void
     */
    protected function _addCategoriesToMenu($categories, $parentCategoryNode, $block)
    {
        foreach ($categories as $category) {
            if (!$category->getIsActive()) {
                continue;
            }
            $block->addIdentity(\Magento\Catalog\Model\Category::CACHE_TAG . '_' . $category->getId());

            $tree = $parentCategoryNode->getTree();
            $categoryData = $this->menuCategoryData->getMenuCategoryData($category);
            $categoryNode = new \Magento\Framework\Data\Tree\Node($categoryData, 'id', $tree, $parentCategoryNode);
            $parentCategoryNode->addChild($categoryNode);

            if ($this->categoryFlatState->isFlatEnabled() && $category->getUseFlatResource()) {
                $subcategories = (array)$category->getChildrenNodes();
            } else {
                $subcategories = $category->getChildren();
            }

            $this->_addCategoriesToMenu($subcategories, $categoryNode, $block);
        }
    }
}
