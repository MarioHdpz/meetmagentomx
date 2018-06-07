<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Ui\DataProvider\Sponsors\Type;


class SponsorsTypeDataProvider extends \Wagento\Sponsors\Ui\DataProvider\Sponsors\Type\DataProvider
{
    /**
     * @var array
     */
    protected $_loadedData;

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->_loadedData)) {
            return $this->_loadedData;
        }

        $sponsorsTypes = $this->collection->getItems();

        foreach ($sponsorsTypes as $sponsorsType) {
            $this->_loadedData[$sponsorsType->getSponsorsTypeId()] = $sponsorsType->getData();
        }

        return $this->_loadedData;
    }

}
