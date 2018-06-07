<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wagento\AjaxCategory\Block\Adminhtml\Form\Field;


class Category extends \Magento\Framework\View\Element\Html\Select
{
    /**
     * @var \Wagento\AjaxCategory\Model\Config\Source\Category
     */
    private $category;

    /**
     * Attribute constructor.
     * @param \Magento\Framework\View\Element\Context $context
     * @param \Wagento\AjaxCategory\Model\Config\Source\Category $category
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Context $context,
        \Wagento\AjaxCategory\Model\Config\Source\Category $category,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->category = $category;
    }

    /**
     * @param string $value
     * @return \Wagento\AjaxCategory\Block\Adminhtml\Form\Field\Category
     */
    public function setInputName($value)
    {
        return $this->setName($value);
    }

    /**
     * Parse to html.
     *
     * @return mixed
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            $attributes = $this->category->toOptionArray();

            foreach ($attributes as $attribute) {
                $this->addOption($attribute['value'], $attribute['label']);
            }
        }

        return parent::_toHtml();
    }
}