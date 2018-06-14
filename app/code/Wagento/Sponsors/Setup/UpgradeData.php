<?php

namespace Wagento\Sponsors\Setup;

use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class UpgradeData implements UpgradeDataInterface {
    /**
     * @var BlockFactory
     */
    private $blockFactory;

    public function __construct(
        BlockFactory $blockFactory
    ) {

        $this->blockFactory = $blockFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '2.0.1', '<')) {
            $stores = array(0);
            foreach ($stores as $store){
                $block = $this->blockFactory->create();
                $block->setTitle('Sponsors Extra Info');
                $block->setIdentifier('sponsors_info');
                $block->setStoreId(array($store));
                $block->setIsActive(1);
                $block->setContent('Edit CMS block: sponsors_info');
                $block->save();
            }
        }
    }

}