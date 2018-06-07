<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Block\Adminhtml\Edit\Sponsors;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;
    /**
     * @var \Wagento\Sponsors\Model\SponsorsFactory
     */
    private $sponsorsFactory;
    /**
     * @var \Wagento\Sponsors\Model\ResourceModel\Sponsors
     */
    private $sponsorsResource;

    /**
     * @param Context $context
     * @param \Wagento\Sponsors\Model\SponsorsFactory $sponsorsFactory
     * @param \Wagento\Sponsors\Model\ResourceModel\Sponsors $sponsorsResource
     */
    public function __construct(
        Context $context,
        \Wagento\Sponsors\Model\SponsorsFactory $sponsorsFactory,
        \Wagento\Sponsors\Model\ResourceModel\Sponsors $sponsorsResource
    ) {
        $this->context = $context;
        $this->sponsorsFactory = $sponsorsFactory;
        $this->sponsorsResource = $sponsorsResource;
    }

    /**
     * Return Sponsors Id
     *
     * @return int|null
     */
    public function getSponsorsId()
    {
        try {
            $model = $this->sponsorsFactory->create();
            $this->sponsorsResource->load($model,$this->context->getRequest()->getParam('sponsors_id'));
            return $model->getSponsorsId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
