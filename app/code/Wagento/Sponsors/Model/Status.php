<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Model;


class Status implements \Magento\Framework\Data\OptionSourceInterface
{
    const ENABLED = 1;
    const DISABLED = 0;

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options[] = ['label' => '', 'value' => ''];
        $availableOptions = $this->getOptionArray();
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }

    public static function getOptionArray()
    {
        return [self::ENABLED => __('Enabled'), self::DISABLED => __('Disabled')];
    }
}
