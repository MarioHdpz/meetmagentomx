<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */

namespace Wagento\Widget\Block;



class SpeakerWidget extends \Magento\CatalogWidget\Block\Product\ProductsList
{

    public $productCacheKey = 'mageplaza_product_slider_cache';

    protected function _construct()
    {
        parent::_construct();
        $this->addColumnCountLayoutDepend('empty', 6)
            ->addColumnCountLayoutDepend('1column', 5)
            ->addColumnCountLayoutDepend('2columns-left', 4)
            ->addColumnCountLayoutDepend('2columns-right', 4)
            ->addColumnCountLayoutDepend('3columns', 3);
        $this->addData([
            'cache_lifetime' => 0,
            'cache_tags'     => [\Magento\Catalog\Model\Product::CACHE_TAG,],
            'cache_key'      => $this->getProductCacheKey(),
        ]);
    }

    public function getProductCacheKey()
    {
        return $this->productCacheKey;
    }
    public function createCollection()
    {
        /** @var $collection \Magento\Catalog\Model\ResourceModel\Product\Collection */
        $collection = $this->productCollectionFactory->create();
        $collection->getSelect()->order('rand()');

        $collection->setVisibility($this->catalogProductVisibility->getVisibleInCatalogIds());

        $collection = $this->_addProductAttributesAndPrices($collection)
            ->addStoreFilter()
           ->setPageSize($this->getPageSize())
            ->setCurPage($this->getRequest()->getParam($this->getData('page_var_name'), 1));

        $conditions = $this->getConditions();
        $conditions->collectValidatedAttributes($collection);
        $this->sqlBuilder->attachConditionToCollection($collection, $conditions);

        /**
         * Prevent retrieval of duplicate records. This may occur when multiselect product attribute matches
         * several allowed values from condition simultaneously
         */
        $collection->distinct(true);

        return $collection;
    }
}