<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */

namespace Wagento\Sponsors\Controller\Adminhtml\Type;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class inlineEdit extends \Magento\Backend\App\Action
{
    /** @var JsonFactory  */
    protected $jsonFactory;
    /**
     * @var \Wagento\Sponsors\Model\SponsorsTypeFactory
     */
    private $sponsorsTypeFactory;
    /**
     * @var \Wagento\Sponsors\Model\ResourceModel\SponsorsType
     */
    private $sponsorsTypeResource;

    /**
     * inlineEdit constructor.
     * @param Context $context
     * @param \Wagento\Sponsors\Model\SponsorsTypeFactory $sponsorsTypeFactory
     * @param \Wagento\Sponsors\Model\ResourceModel\SponsorsType $sponsorsTypeResource
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        \Wagento\Sponsors\Model\SponsorsTypeFactory $sponsorsTypeFactory,
        \Wagento\Sponsors\Model\ResourceModel\SponsorsType $sponsorsTypeResource,
        JsonFactory $jsonFactory
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->sponsorsTypeFactory = $sponsorsTypeFactory;
        $this->sponsorsTypeResource = $sponsorsTypeResource;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }

        foreach (array_keys($postItems) as $id) {
            $sponsorsType = $this->sponsorsTypeFactory->create();
            $this->sponsorsTypeResource->load($sponsorsType,$id);
            try {
                $sponsorsTypeData = $postItems[$id];
                $sponsorsType->setData($sponsorsTypeData);
                $this->sponsorsTypeResource->save($sponsorsType);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithSponsorsType($sponsorsType, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithSponsorsType($sponsorsType, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithSponsorsType(
                    $sponsorsType,
                    __('Something went wrong while saving the page.')
                );
                $error = true;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * @param \Wagento\Sponsors\Model\SponsorsType $sponsorsType
     * @param $errorText
     * @return string
     */
    protected function getErrorWithSponsorsType(\Wagento\Sponsors\Model\SponsorsType $sponsorsType, $errorText)
    {
        return '[Sponsors Type ID: ' . $sponsorsType->getSponsorsTypeId() . '] ' . $errorText;
    }
}
