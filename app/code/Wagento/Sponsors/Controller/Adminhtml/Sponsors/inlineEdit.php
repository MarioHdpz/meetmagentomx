<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */

namespace Wagento\Sponsors\Controller\Adminhtml\Sponsors;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;

class inlineEdit extends \Magento\Backend\App\Action
{
    /** @var JsonFactory  */
    protected $jsonFactory;
    /**
     * @var \Wagento\Sponsors\Model\SponsorsFactory
     */
    private $sponsorsFactory;
    /**
     * @var \Wagento\Sponsors\Model\ResourceModel\Sponsors
     */
    private $sponsorsResource;

    /**
     * inlineEdit constructor.
     * @param Context $context
     * @param \Wagento\Sponsors\Model\SponsorsFactory $sponsorsFactory
     * @param \Wagento\Sponsors\Model\ResourceModel\Sponsors $sponsorsResource
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        \Wagento\Sponsors\Model\SponsorsFactory $sponsorsFactory,
        \Wagento\Sponsors\Model\ResourceModel\Sponsors $sponsorsResource,
        JsonFactory $jsonFactory
    ) {
        $this->jsonFactory = $jsonFactory;
        $this->sponsorsFactory = $sponsorsFactory;
        $this->sponsorsResource = $sponsorsResource;
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
            $sponsors = $this->sponsorsFactory->create();
            $this->sponsorsResource->load($sponsors,$id);
            try {
                $sponsorsData = $postItems[$id];
                $sponsors->setData($sponsorsData);
                $this->sponsorsResource->save($sponsors);
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $messages[] = $this->getErrorWithSponsors($sponsors, $e->getMessage());
                $error = true;
            } catch (\RuntimeException $e) {
                $messages[] = $this->getErrorWithSponsors($sponsors, $e->getMessage());
                $error = true;
            } catch (\Exception $e) {
                $messages[] = $this->getErrorWithSponsors(
                    $sponsors,
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
    protected function getErrorWithSponsors(\Wagento\Sponsors\Model\Sponsors $sponsors, $errorText)
    {
        return '[Sponsors ID: ' . $sponsors->getSponsorsId() . '] ' . $errorText;
    }
}
