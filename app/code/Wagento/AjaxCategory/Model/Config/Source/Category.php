<?php
namespace Wagento\AjaxCategory\Model\Config\Source;

/**
 * Copyright © 2017 Wagento. All rights reserved.
 */

use Magento\Framework\Option\ArrayInterface;

class Category implements ArrayInterface
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    private $categoryCollectionFactory;
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * Category constructor.
     * @param \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     */
    public function __construct(\Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
                                \Magento\Store\Model\StoreManagerInterface $storeManager)
    {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
        $this->storeManager = $storeManager;
    }

    public function toOptionArray()
    {
      $storeId = $this->storeManager->getDefaultStoreView()->getId();
	  $categoryCollection = $this->categoryCollectionFactory->create();
	  $categoryCollection->setProductStoreId($storeId);
	  $categoryCollection->addAttributeToSelect('*');
      $categoryCollection->addFieldToFilter('level', 2);
	  $categoryCollection->addIsActiveFilter();

	  $options = [];
	  foreach ($categoryCollection as $cat) {
          if($cat->getName() != '') {
              $options[] = ['label' => $cat->getName(), 'value' => $cat->getId()];
          }
	  }
	  return $options;
    }
}
