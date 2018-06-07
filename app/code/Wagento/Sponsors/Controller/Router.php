<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Controller;

use Magento\Framework\App\RouterInterface;
use Magento\Framework\App\ActionFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Event\ManagerInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Url;

class Router implements RouterInterface
{
    /**
     * @var \Magento\Framework\App\ActionFactory
     */
    protected $actionFactory;

    /**
     * Event manager
     * @var \Magento\Framework\Event\ManagerInterface
     */
    protected $eventManager;

    /**
     * Response
     * @var \Magento\Framework\App\ResponseInterface
     */
    protected $response;

    /**
     * @var bool
     */
    protected $dispatched;
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;
    /**
     * @var \Wagento\Sponsors\Helper\Data
     */
    protected $sponsorsHelper;

    /**
     * Router constructor.
     * @param ActionFactory $actionFactory
     * @param ResponseInterface $response
     * @param ManagerInterface $eventManager
     * @param \Wagento\Sponsors\Helper\Data $sponsorsHelper
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ActionFactory $actionFactory,
        ResponseInterface $response,
        ManagerInterface $eventManager,
        \Wagento\Sponsors\Helper\Data $sponsorsHelper,
        StoreManagerInterface $storeManager
    ) {
        $this->actionFactory = $actionFactory;
        $this->eventManager = $eventManager;
        $this->response = $response;
        $this->storeManager = $storeManager;
        $this->sponsorsHelper = $sponsorsHelper;
    }

    /**
     * @param RequestInterface $request
     *
     * @return \Magento\Framework\App\ActionInterface
     */
    public function match(RequestInterface $request)
    {
        if (!$this->dispatched) {
            $urlKey = trim($request->getPathInfo(), '/');
            /** @var Object $condition */
            $condition = new DataObject(['url_key' => $urlKey, 'continue' => true]);
            $this->eventManager->dispatch(
                'wagento_sponsors_controller_router_match_before',
                ['router' => $this, 'condition' => $condition]
            );
            $urlKey = $condition->getUrlKey();
            if ($condition->getRedirectUrl()) {
                $this->response->setRedirect($condition->getRedirectUrl());
                $request->setDispatched(true);

                return $this->actionFactory->create(
                    'Magento\Framework\App\Action\Redirect',
                    ['request' => $request]
                );
            }
            if (!$condition->getContinue()) {
                return null;
            }
            $route = $this->sponsorsHelper->getFrontendUrlPath();
            if ($urlKey == $route && $this->sponsorsHelper->isEnable() && $this->sponsorsHelper->showMenuBar() && !empty($route)) {
                $request->setModuleName('sponsors')
                    ->setControllerName('index')
                    ->setActionName('index');
                $request->setAlias(Url::REWRITE_REQUEST_PATH_ALIAS, $urlKey);
                $this->dispatched = true;

                return $this->actionFactory->create(
                    'Magento\Framework\App\Action\Forward',
                    ['request' => $request]
                );
            }
        }
    }
}