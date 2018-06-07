<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Block\Adminhtml\Edit\Type;

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
     * @var \Wagento\Sponsors\Model\ResourceModel\SponsorsType
     */
    private $sponsorsTypeResource;
    /**
     * @var \Wagento\Sponsors\Model\SponsorsTypeFactory
     */
    private $sponsorsTypeFactory;

    /**
     * @param Context $context
     * @param \Wagento\Sponsors\Model\SponsorsTypeFactory $sponsorsTypeFactory
     * @param \Wagento\Sponsors\Model\ResourceModel\SponsorsType $sponsorsTypeResource
     */
    public function __construct(
        Context $context,
        \Wagento\Sponsors\Model\SponsorsTypeFactory $sponsorsTypeFactory,
        \Wagento\Sponsors\Model\ResourceModel\SponsorsType $sponsorsTypeResource
    ) {
        $this->context = $context;
        $this->sponsorsTypeResource = $sponsorsTypeResource;
        $this->sponsorsTypeFactory = $sponsorsTypeFactory;
    }

    /**
     * Return Sponsors Type Id
     *
     * @return int|null
     */
    public function getSponsorsTypeId()
    {
        try {
            $model = $this->sponsorsTypeFactory->create();
            $this->sponsorsTypeResource->load($model,$this->context->getRequest()->getParam('sponsors_type_id'));
            return $model->getSponsorsTypeId();
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
