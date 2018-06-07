<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Controller\Index;

use Wagento\Sponsors\Helper\Data;
use Magento\Framework\Controller\ResultFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var Data
     */
    public $helper;

    /**
     * Action constructor
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param Data $helper
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        Data $helper
    ) {
        parent::__construct($context);
        $this->helper = $helper;
    }

    /**
     * Execute action
     */
    public function execute()
    {
        if(!$this->helper->isEnable()) {
            $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $resultRedirect->setPath('cms/noroute');
        }
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getConfig()->getTitle()->set($this->helper->getTitle());

        return $resultPage;
    }
}
