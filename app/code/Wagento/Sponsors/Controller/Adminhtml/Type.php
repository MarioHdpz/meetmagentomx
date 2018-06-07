<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Controller\Adminhtml;

abstract class Type extends \Wagento\Sponsors\Controller\Adminhtml\AbstractAction
{
    const PARAM_CRUD_ID = 'sponsors_type_id';

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Wagento_Sponsors::sponsors_type');
    }
}