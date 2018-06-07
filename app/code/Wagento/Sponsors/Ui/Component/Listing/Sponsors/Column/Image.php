<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Ui\Component\Listing\Sponsors\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Listing\Columns\Column;

class Image extends Column
{
    /**
     * default width and height image.
     */
    const IMAGE_WIDTH = '50%';
    const IMAGE_HEIGHT = '50%';
    const IMAGE_STYLE = 'display: block;margin: auto;';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * Constructor.
     *
     * @param ContextInterface   $context
     * @param UiComponentFactory $uiComponentFactory
     * @param array              $components
     * @param array              $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->_storeManager = $storeManager;
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$item) {
                $this->_prepareItem($item);
            }
        }

        return $dataSource;
    }

    /**
     * prepare item.
     *
     * @param array $item
     *
     * @return array
     */
    protected function _prepareItem(array & $item)
    {
        $width = $this->hasData('width') ? $this->getWidth() : self::IMAGE_WIDTH;
        $height = $this->hasData('height') ? $this->getHeight() : self::IMAGE_HEIGHT;
        $style = $this->hasData('style') ? $this->getStyle() : self::IMAGE_STYLE;
        if (isset($item['image'])) {
            $imageUrl = $this->_storeManager->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ) . 'sponsors/image/' . $item['image'];
            $item['image'] = sprintf(
                '<img src="%s" width="%s" height="%s" style="%s"/>',
                $imageUrl,
                $width,
                $height,
                $style
            );
        } else {
            $item['image'] = '';
        }
        return $item;
    }
}
