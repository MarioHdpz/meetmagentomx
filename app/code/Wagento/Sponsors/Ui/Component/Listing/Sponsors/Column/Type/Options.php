<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Ui\Component\Listing\Sponsors\Column\Type;


class Options implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var \Wagento\Sponsors\Model\ResourceModel\SponsorsType\Collection
     */
    private $sponsorsTypeCollection;

    /**
     * Options constructor.
     * @param \Wagento\Sponsors\Model\ResourceModel\SponsorsType\Collection $sponsorsTypeCollection
     */
    public function __construct(\Wagento\Sponsors\Model\ResourceModel\SponsorsType\Collection $sponsorsTypeCollection)
    {
        $this->sponsorsTypeCollection = $sponsorsTypeCollection;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        $sponsorsCollection = $this->sponsorsTypeCollection;
        foreach ($sponsorsCollection as $value) {
            $options[] = [
                'label' => $value->getTitle(),
                'value' => $value->getSponsorsTypeId()
            ];
        }
        return $options;
    }
}
