<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Pengo\ContactSpeaker\Controller\Index;

use Magento\Framework\Controller\ResultFactory;

class Index extends \Pengo\ContactSpeaker\Controller\Index
{
    /**
     * Show Contact Us page
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
