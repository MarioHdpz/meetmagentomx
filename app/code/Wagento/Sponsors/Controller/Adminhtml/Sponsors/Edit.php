<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Controller\Adminhtml\Sponsors;

class Edit extends \Magento\Backend\App\Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Edit constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Wagento_Sponsors::save');
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Wagento_Sponsors::sponsors')
            ->addBreadcrumb(__('Wagento'), __('Wagento'))
            ->addBreadcrumb(__('Manage Sponsors'), __('Manage Sponsors'));
        return $resultPage;
    }

    /**
     * Edit sponsors type
     *
     * @return \Magento\Backend\Model\View\Result\Page|\Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('sponsors_id');
        $model = $this->_objectManager->create('Wagento\Sponsors\Model\Sponsors');

        if ($id) {
            $model->load($id);
            if (!$model->getSponsorsId()) {
                $this->messageManager->addError(__('This sponsor no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);

        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('sponsors', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();

        $resultPage->addBreadcrumb(
            $id ? __('Edit Sponsor') : __('New Sponsor'),
            $id ? __('Edit Sponsor') : __('New Sponsor')
        );

        $resultPage->getConfig()->getTitle()->prepend(__('Sponsors'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getSponsorsId() ? $model->getTitle() : __('Edit Sponsor'));

        return $resultPage;
    }
}