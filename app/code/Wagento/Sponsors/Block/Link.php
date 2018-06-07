<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Block;

class Link extends \Magento\Framework\View\Element\Html\Link
{
    /**
     * @var \Wagento\Sponsors\Helper\Data
     */
    private $sponsorsData;

    /**
     * Link constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Wagento\Sponsors\Helper\Data $sponsorsData
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Wagento\Sponsors\Helper\Data $sponsorsData,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->sponsorsData = $sponsorsData;
    }

    /**
     * Render block HTML.
     *
     * @return string
     */
    protected function _toHtml()
    {
        $check = ($this->sponsorsData->isEnable() && $this->sponsorsData->showTopLink());

        return $check ? parent::_toHtml() : '';
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->_storeManager->getStore()->getUrl(
            $this->sponsorsData->getFrontendUrlPath()
        );
    }
}