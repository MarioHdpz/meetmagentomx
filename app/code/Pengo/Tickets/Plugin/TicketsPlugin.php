<?php

namespace Pengo\Tickets\Plugin;

class TicketsPlugin
{
    /**
     * @var \Magento\Checkout\Model\Session
     */
    private $checkoutSession;
    /**
     * @var \Magento\Checkout\Model\Cart
     */
    private $cart;
    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    private $messageManager;
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;
    /**
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * TicketsPlugin constructor.
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Checkout\Model\Cart $cart
     * @param \Magento\Framework\Message\ManagerInterface $messageManager
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Checkout\Model\Cart $cart,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
    ) {
        $this->checkoutSession = $checkoutSession;
        $this->cart = $cart;
        $this->messageManager = $messageManager;
        $this->logger = $logger;
        $this->productRepository = $productRepository;
        $this->scopeConfig = $scopeConfig;
    }

    public function beforeExecute(
        \Magento\Checkout\Controller\Cart\Index $subject
    ) {
        if($this->scopeConfig->getValue('tickets/ticket_product/enabled')) {
            $quote = $this->checkoutSession->getQuote();
            if (!count($quote->getAllItems())) {
                try {
                    $product = $this->_initProduct();

                    /**
                     * Check product availability
                     *
                    if (!$product) {
                    }*/
                    $request = new \Magento\Framework\DataObject(['qty' => 1]);

                    $this->cart->addProduct($product, $request);
                    $this->cart->save();
                    $this->checkoutSession->getQuote()->setTotalsCollectedFlag(false)->collectTotals()->save();

                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__('We can\'t add tickets right now, please try again later'));
                    $this->logger->critical($e);
                }
            }
        }
    }

    /**
     * Initialize product instance from request data
     *
     * @return \Magento\Catalog\Model\Product|false
     */
    protected function _initProduct()
    {
        $productId = $this->scopeConfig->getValue('tickets/ticket_product/product_id');
        if ($productId) {
            $storeId = $this->checkoutSession->getQuote()->getStoreId();
            try {
                return $this->productRepository->getById($productId, false, $storeId, true);
            } catch (\Exception $e) {
                return false;
            }
        }
        return false;
    }
}
