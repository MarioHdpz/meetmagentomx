<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Controller\Adminhtml\Type;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Wagento_Sponsors::delete');
    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('sponsors_type_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->_objectManager->create('Wagento\Sponsors\Model\SponsorsType');
                $model->load($id);
                $model->delete();
                $this->messageManager->addSuccess(__('The sponsers type has been deleted.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addError ($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['sponsors_type_id' => $id]);
            }
        }
        $this->messageManager->addError(__('We can\'t find a sponsers type to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}