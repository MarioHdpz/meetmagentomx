<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Speaker\Setup;

use Magento\Eav\Setup\EavSetupFactory as BaseSetupFactory;


class EavSetupFactory extends BaseSetupFactory
{
    /**
     * Internal constructor.
     *
     * @param \Magento\Framework\ObjectManagerInterface $objectManager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectManager)
    {
        parent::__construct($objectManager, '\\Wagento\\Speaker\\Setup\\EavSetup');
    }
}
