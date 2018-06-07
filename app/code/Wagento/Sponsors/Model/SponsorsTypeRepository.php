<?php
/**
 * Copyright © 2017 Wagento. All rights reserved.
 */
namespace Wagento\Sponsors\Model;


use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use Wagento\Sponsors\Api\Data\SponsorsTypeInterface;
use Wagento\Sponsors\Api\SponsorsTypeRepositoryInterface;

class SponsorsTypeRepository implements SponsorsTypeRepositoryInterface
{
    /**
     * @var SponsorsTypeFactory
     */
    private $sponsorsTypeFactory;
    /**
     * @var ResourceModel\SponsorsType
     */
    private $sponsorsTypeResource;
    /**
     * @var \Wagento\Sponsors\Api\Data\SponsorsTypeInterfaceFactory
     */
    private $sponsorsTypeInterfaceFactory;
    /**
     * @var \Wagento\Sponsors\Api\Data\SponsorsTypeSearchResultsInterfaceFactory
     */
    private $sponsorsTypeSearchResultsInterfaceFactory;

    /**
     * SponsorsTypeRepository constructor.
     * @param SponsorsTypeFactory $sponsorsTypeFactory
     * @param ResourceModel\SponsorsType $sponsorsTypeResource
     * @param \Wagento\Sponsors\Api\Data\SponsorsTypeInterfaceFactory $sponsorsTypeInterfaceFactory
     * @param \Wagento\Sponsors\Api\Data\SponsorsTypeSearchResultsInterfaceFactory $sponsorsTypeSearchResultsInterfaceFactory
     */
    public function __construct(
        \Wagento\Sponsors\Model\SponsorsTypeFactory $sponsorsTypeFactory,
        \Wagento\Sponsors\Model\ResourceModel\SponsorsType $sponsorsTypeResource,
        \Wagento\Sponsors\Api\Data\SponsorsTypeInterfaceFactory $sponsorsTypeInterfaceFactory,
        \Wagento\Sponsors\Api\Data\SponsorsTypeSearchResultsInterfaceFactory $sponsorsTypeSearchResultsInterfaceFactory
    )
    {
        $this->sponsorsTypeFactory = $sponsorsTypeFactory;
        $this->sponsorsTypeResource = $sponsorsTypeResource;
        $this->sponsorsTypeInterfaceFactory = $sponsorsTypeInterfaceFactory;
        $this->sponsorsTypeSearchResultsInterfaceFactory = $sponsorsTypeSearchResultsInterfaceFactory;
    }

    /**
     * Retrieve sponsors type matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Wagento\Sponsors\Api\Data\SponsorsTypeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->sponsorsTypeFactory->create()->getCollection();

        $searchResults = $this->sponsorsTypeSearchResultsInterfaceFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $this->applySearchCriteriaToCollection($searchCriteria, $collection);
        $sponsors = $this->convertCollectionToDataItemsArray($collection);

        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($sponsors);

        return $searchResults;
    }

    /**
     * Save sponsors type.
     *
     * @param \Wagento\Sponsors\Api\Data\SponsorsTypeInterface $sponsorsType
     * @return \Wagento\Sponsors\Api\Data\SponsorsTypeInterface
     * @throws \Magento\Framework\Exception\InputException If bad input is provided
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Wagento\Sponsors\Api\Data\SponsorsTypeInterface $sponsorsType)
    {
        $sponsorsTypeModel = $sponsorsType->getSponsorsTypeId()?
            $this->loadSponsorsTypeModel($sponsorsType->getSponsorsTypeId()) :
            $this->sponsorsTypeFactory->create();

        $sponsorsTypeModel->setSponsorsTypeId($sponsorsType->getSponsorsTypeId());
        $sponsorsTypeModel->setTitle($sponsorsType->getTitle());
        $sponsorsTypeModel->setRequiredSponsors($sponsorsType->getRequiredSponsors());
        $sponsorsTypeModel->setColumn($sponsorsType->getColumn());
        $sponsorsTypeModel->setStatus($sponsorsType->getStatus());
        $sponsorsTypeModel->setSortOrder($sponsorsType->getSortOrder());
        $sponsorsTypeModel->setCreatedAt($sponsorsType->getCreatedAt());
        $sponsorsTypeModel->setUpdatedAt($sponsorsType->getUpdatedAt());

        $this->sponsorsTypeResource->save($sponsorsTypeModel);
        return $this->getById($sponsorsTypeModel->getSponsorsId());
    }

    /**
     * Retrieve sponsors type.
     *
     * @param int $sponsorsTypeId
     * @return \Wagento\Sponsors\Api\Data\SponsorsTypeInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($sponsorsTypeId)
    {
        $sponsorsTypeModel = $this->loadSponsorsTypeModel($sponsorsTypeId);
        return $sponsorsTypeModel;
    }

    /**
     * @param $identifier
     * @param null|string $field
     * @return \Wagento\Sponsors\Model\SponsorsType
     * @throws NoSuchEntityException
     */
    protected function loadSponsorsTypeModel($identifier, $field = null)
    {
        $sponsorsTypeModel = $this->sponsorsTypeFactory->create();
        $this->sponsorsTypeResource->load($sponsorsTypeModel, $identifier, $field);
        if (!$sponsorsTypeModel->getSponsorsTypeId()) {
            // sponsors type does not exist
            throw NoSuchEntityException::singleField(SponsorsTypeInterface::SPONSORS_TYPE_ID, $identifier);
        }
        return $sponsorsTypeModel;
    }

    /**
     * Delete sponsors type.
     *
     * @param \Wagento\Sponsors\Api\Data\SponsorsTypeInterface $sponsorsType
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Wagento\Sponsors\Api\Data\SponsorsTypeInterface $sponsorsType)
    {
        try {
            $this->sponsorsTypeResource->delete($sponsorsType);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the sponsors type: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * Delete sponsors type by ID.
     *
     * @param int $sponsorsTypeId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($sponsorsTypeId)
    {
        return $this->delete($this->getById($sponsorsTypeId));
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
        $sponsorsType = array_map(function (SponsorsType $sponsorsType){

            $dataObject = $this->sponsorsTypeFactory->create();
            $dataObject->setSponsorsTypeId($sponsorsType->getSponsorsTypeId());
            $dataObject->setTitle($sponsorsType->getTitle());
            $dataObject->setRequiredSponsors($sponsorsType->getRequiredSponsors());
            $dataObject->setColumn($sponsorsType->getColumn());
            $dataObject->setStatus($sponsorsType->getStatus());
            $dataObject->setSortOrder($sponsorsType->getSortOrder());
            $dataObject->setCreatedAt($sponsorsType->getCreatedAt());
            $dataObject->setUpdatedAt($sponsorsType->getUpdatedAt());
            return $dataObject;

        }, $collection->getItems());
        return $sponsorsType;
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