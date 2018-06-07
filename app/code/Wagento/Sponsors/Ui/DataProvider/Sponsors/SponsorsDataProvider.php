<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Ui\DataProvider\Sponsors;


class SponsorsDataProvider extends \Wagento\Sponsors\Ui\DataProvider\Sponsors\DataProvider
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

        $sponsors = $this->collection->getItems();

        foreach ($sponsors as $sponsor) {
            $sponsorData = $sponsor->getData();
            if (isset($sponsorData['image'])) {
                unset($sponsorData['image']);
                $sponsorData['image'][0]['name'] = $sponsor->getData('image');
                $imageUrl = $this->storeManager->getStore()->getBaseUrl(
                        \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                    ) . 'sponsors/image/' . $sponsor->getData('image');
                $sponsorData['image'][0]['url'] = $imageUrl;
            }
            $this->_loadedData[$sponsor->getSponsorsId()] = $sponsorData;
        }

        return $this->_loadedData;
    }

}
