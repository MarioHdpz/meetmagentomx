<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Controller\Adminhtml\Sponsors;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;
use Wagento\Sponsors\Model\SponsorsFactory;

class Save extends \Magento\Backend\App\Action
{

    public $imageUploader;
    /**
     * @var DirectoryList
     */
    private $directoryList;
    /**
     * @var SponsorsFactory
     */
    private $sponsorsFactory;

    /**
     * Save constructor.
     * @param Action\Context $context
     * @param SponsorsFactory $sponsorsFactory
     * @param DirectoryList $directoryList
     */
    public function __construct(Action\Context $context, SponsorsFactory $sponsorsFactory, DirectoryList $directoryList)
    {
        parent::__construct($context);
        $this->sponsorsFactory = $sponsorsFactory;
        $this->directoryList = $directoryList;
    }

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
            /** @var \Wagento\Sponsors\Model\Sponsors $model */
            $model = $this->_objectManager->create('Wagento\Sponsors\Model\Sponsors');
            $id = $this->getRequest()->getParam('sponsors_id');
            if ($id) {
                $model->load($id);
            } else {
                unset($data['sponsors_id']);
            }

            if (isset($data['image'])) {
                $image = $data['image'][0]['name'];
                $data['image'] = $image;
                try {
                    $imageFile = $this->directoryList->getPath(DirectoryList::MEDIA) . '/sponsors/image/' . $image;
                    $tmpImageFile = $this->directoryList->getPath(DirectoryList::MEDIA) . '/sponsors/tmp/image/' . $image;
                    if(!file_exists($imageFile)) {
                        $this->getImageUploader()->moveFileFromTmp($image);
                    }elseif(file_exists($tmpImageFile)) {
                        unlink($tmpImageFile);
                    }
                }catch (\Exception $e) {
                    $this->messageManager->addError(__($e->getMessage()));
                }
            }

            $model->setData($data);
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the sponsors.'));
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['sponsors_id' => $model->getSponsorsId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the sponsors.'));
            }
            return $resultRedirect->setPath('*/*/edit', ['sponsors_id' => $this->getRequest()->getParam('sponsors_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    private function getImageUploader()
    {
        if ($this->imageUploader === null) {
            $this->imageUploader = \Magento\Framework\App\ObjectManager::getInstance()->get(
                'Wagento\Sponsors\Image\Upload'
            );
        }
        return $this->imageUploader;
    }
}