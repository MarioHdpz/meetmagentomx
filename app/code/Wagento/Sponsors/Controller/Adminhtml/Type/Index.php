<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Controller\Adminhtml\Type;

class Index extends \Wagento\Sponsors\Controller\Adminhtml\Type
{
    public function execute()
    {
        $resultPage = $this->_resultPageFactory->create();
        return $resultPage;
    }
}
