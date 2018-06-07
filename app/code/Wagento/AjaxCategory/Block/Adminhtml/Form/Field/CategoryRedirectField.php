<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wagento\AjaxCategory\Block\Adminhtml\Form\Field;


class CategoryRedirectField extends \Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray
{
    /**
     * @var $_attribute \Wagento\AjaxCategory\Block\Adminhtml\Form\Field\Category
     */
    protected $_attribute;

    /**
     * Get attribute options.
     *
     * @return \Wagento\AjaxCategory\Block\Adminhtml\Form\Field\Category
     */
    protected function _getAttributeRenderer()
    {
        if (!$this->_attribute) {
            $this->_attribute = $this->getLayout()->createBlock(
                '\Wagento\AjaxCategory\Block\Adminhtml\Form\Field\Category',
                '',
                ['data' => ['is_render_to_js_template' => true]]
            );
        }

        return $this->_attribute;
    }

    /**
     * Prepare to render.
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'cat_id',
            [
                'label' => __('Category'),
                'renderer' => $this->_getAttributeRenderer()
            ]
        );
        $this->addColumn('redirect_url', ['label' => __('Redirect')]);

        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add');
    }

    /**
     * Prepare existing row data object.
     *
     * @param \Magento\Framework\DataObject $row
     * @return void
     */
    protected function _prepareArrayRow(\Magento\Framework\DataObject $row)
    {
        $options = [];
        $customAttribute = $row->getData('cat_id');

        $key = 'option_' . $this->_getAttributeRenderer()->calcOptionHash($customAttribute);
        $options[$key] = 'selected="selected"';
        $row->setData('option_extra_attrs', $options);
    }
}