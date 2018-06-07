<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Wagento\Sponsors\Controller\Adminhtml\Type;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{
    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            /** @var \Wagento\Sponsors\Model\SponsorsType $model */
            $model = $this->_objectManager->create('Wagento\Sponsors\Model\SponsorsType');
            $id = $this->getRequest()->getParam('sponsors_type_id');
            if ($id) {
                $model->load($id);
            } else {
                unset($data['sponsors_type_id']);
            }
            $model->setData($data);
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the sponsors type.'));
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['sponsors_type_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the sponsors type.'));
            }
            return $resultRedirect->setPath('*/*/edit', ['sponsors_type_id' => $this->getRequest()->getParam('sponsors_type_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}