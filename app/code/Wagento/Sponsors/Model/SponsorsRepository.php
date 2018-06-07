<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Wagento\Sponsors\Api\Data\SponsorsInterface;
use Wagento\Sponsors\Api\SponsorsRepositoryInterface;

class SponsorsRepository implements SponsorsRepositoryInterface
{
    /**
     * @var SponsorsFactory
     */
    private $sponsorsFactory;
    /**
     * @var ResourceModel\Sponsors
     */
    private $sponsorsResource;
    /**
     * @var \Wagento\Sponsors\Api\Data\SponsorsInterfaceFactory
     */
    private $sponsorsInterfaceFactory;
    /**
     * @var \Wagento\Sponsors\Api\Data\SponsorsSearchResultsInterfaceFactory
     */
    private $sponsorsSearchResultsInterfaceFactory;

    /**
     * SponsorsRepository constructor.
     * @param SponsorsFactory $sponsorsFactory
     * @param ResourceModel\Sponsors $sponsorsResource
     * @param \Wagento\Sponsors\Api\Data\SponsorsInterfaceFactory $sponsorsInterfaceFactory
     * @param \Wagento\Sponsors\Api\Data\SponsorsSearchResultsInterfaceFactory $sponsorsSearchResultsInterfaceFactory
     */
    public function __construct(
        \Wagento\Sponsors\Model\SponsorsFactory $sponsorsFactory,
        \Wagento\Sponsors\Model\ResourceModel\Sponsors $sponsorsResource,
        \Wagento\Sponsors\Api\Data\SponsorsInterfaceFactory $sponsorsInterfaceFactory,
        \Wagento\Sponsors\Api\Data\SponsorsSearchResultsInterfaceFactory $sponsorsSearchResultsInterfaceFactory
    )
    {
        $this->sponsorsFactory = $sponsorsFactory;
        $this->sponsorsResource = $sponsorsResource;
        $this->sponsorsInterfaceFactory = $sponsorsInterfaceFactory;
        $this->sponsorsSearchResultsInterfaceFactory = $sponsorsSearchResultsInterfaceFactory;
    }

    /**
     * Retrieve sponsors matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Wagento\Sponsors\Api\Data\SponsorsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->sponsorsFactory->create()->getCollection();

        $searchResults = $this->sponsorsSearchResultsInterfaceFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $this->applySearchCriteriaToCollection($searchCriteria, $collection);
        $sponsors = $this->convertCollectionToDataItemsArray($collection);

        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($sponsors);

        return $searchResults;
    }

    /**
     * Save sponsors.
     *
     * @param \Wagento\Sponsors\Api\Data\SponsorsInterface $sponsors
     * @return \Wagento\Sponsors\Api\Data\SponsorsInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Wagento\Sponsors\Api\Data\SponsorsInterface $sponsors)
    {
        $sponsorsModel = $sponsors->getSponsorsId()?
            $this->loadSponsorsModel($sponsors->getSponsorsId()) :
            $this->sponsorsFactory->create();

        $sponsorsModel->setSponsorsId($sponsors->getSponsorsId());
        $sponsorsModel->setSponsorsTypeId($sponsors->getSponsorsTypeId());
        $sponsorsModel->setName($sponsors->getName());
        $sponsorsModel->setUrlKey($sponsors->getUrlKey());
        $sponsorsModel->setImage($sponsors->getImage());
        $sponsorsModel->setStatus($sponsors->getStatus());
        $sponsorsModel->setPosition($sponsors->getPosition());
        $sponsorsModel->setCreatedAt($sponsors->getCreatedAt());
        $sponsorsModel->setUpdatedAt($sponsors->getUpdatedAt());

        $this->sponsorsResource->save($sponsorsModel);
        return $this->getById($sponsorsModel->getSponsorsId());
    }

    /**
     * Retrieve sponsors.
     *
     * @param int $sponsorsId
     * @return \Wagento\Sponsors\Api\Data\SponsorsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($sponsorsId)
    {
        $sponsorsModel = $this->loadSponsorsModel($sponsorsId);
        return $sponsorsModel;
    }

    /**
     * @param $identifier
     * @param null|string $field
     * @return \Wagento\Sponsors\Model\Sponsors
     * @throws NoSuchEntityException
     */
    protected function loadSponsorsModel($identifier, $field = null)
    {
        $sponsorsModel = $this->sponsorsFactory->create();
        $this->sponsorsResource->load($sponsorsModel, $identifier, $field);
        if (!$sponsorsModel->getSponsorsId()) {
            // sponsors does not exist
            throw NoSuchEntityException::singleField(SponsorsInterface::SPONSORS_ID, $identifier);
        }
        return $sponsorsModel;
    }

    /**
     * Delete sponsors.
     *
     * @param \Wagento\Sponsors\Api\Data\SponsorsInterface $sponsors
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Wagento\Sponsors\Api\Data\SponsorsInterface $sponsors)
    {
        try {
            $this->sponsorsResource->delete($sponsors);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the sponsor : %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete sponsors by ID.
     *
     * @param int $sponsorsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($sponsorsId)
    {
        return $this->delete($this->getById($sponsorsId));
    }

    /**
     * @param FilterGroup $filterGroup
     * @param Collection $collection
     */
    private function addFilterGroupToCollection(
        FilterGroup $filterGroup,
        Collection $collection
    ){
        $fields = [];
        $conditions = [];
        foreach ($filterGroup->getFilters() as $filter){
            $condition = $filter->getConditionType() ? $filter->getConditionType() : 'eq';
            $fields[] = $filter->getField();
            $conditions[] = [$condition => $filter->getValue()];
        }
        if($fields){
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    private function convertCollectionToDataItemsArray($collection)
    {
        $sponsors = array_map(function (Sponsors $sponsors){

            $dataObject = $this->sponsorsFactory->create();
            $dataObject->setSponsorsId($sponsors->getSponsorsId());
            $dataObject->setSponsorsTypeId($sponsors->getSponsorsTypeId());
            $dataObject->setName($sponsors->getName());
            $dataObject->setUrlKey($sponsors->getUrlKey());
            $dataObject->setImage($sponsors->getImage());
            $dataObject->setStatus($sponsors->getStatus());
            $dataObject->setPosition($sponsors->getPosition());
            $dataObject->setCreatedAt($sponsors->getCreatedAt());
            $dataObject->setUpdatedAt($sponsors->getUpdatedAt());
            return $dataObject;

        }, $collection->getItems());
        return $sponsors;
    }

    private function applySearchCriteriaToCollection($searchCriteria, $collection)
    {
        $this->applySearchCriteriaFiltersToCollection($searchCriteria, $collection);
        $this->applySearchCriteriaSortOrdersToCollection($searchCriteria, $collection);
        $this->applySearchCriteriaPagingToCollection($searchCriteria, $collection);
    }

    private function applySearchCriteriaFiltersToCollection($searchCriteria, $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $group){
            $this->addFilterGroupToCollection($group, $collection);
        }
    }

    private function applySearchCriteriaSortOrdersToCollection($searchCriteria, $collection)
    {
        $sortOrders = $searchCriteria->getSortOrders();
        if($sortOrders){
            $isAscending = $sortOrders->getDirection() == SearchCriteriaInterface::SORT_ASC;
            foreach ($sortOrders as $sortOrder){
                $collection->addOrder(
                    $sortOrder->getField(), $isAscending ? 'ASC' : 'DESC'
                );
            }
        }
    }

    private function applySearchCriteriaPagingToCollection($searchCriteria, $collection)
    {
        $collection->setCurpage($searchCriteria->getCurrentpage());
        $collection->setPageSize($searchCriteria->getPageSize());
    }
}