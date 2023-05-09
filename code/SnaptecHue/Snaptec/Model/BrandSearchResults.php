<?php

namespace SnaptecHue\Snaptec\Model;
use Magento\Framework\Api\SearchCriteriaInterface;
use SnaptecHue\Snaptec\Api\BrandSearchResultsInterface;


class BrandSearchResults implements BrandSearchResultsInterface{

    protected $items;
    protected $searchCriteria;
    protected $totalCount;
    public function getItems(){
        return $this->items;
    }
    public function setItems(array $items)
    {
        $this->items = $items;
        return $this;
    }
    // getSearchCriteria', 'setSearchCriteria', 'getTotalCount', 'setTotalCount'intelephense(1037)
    public function getSearchCriteria(){
        return $this->searchCriteria;
    }
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria)
    {
        $this->searchCriteria = $searchCriteria;
        return $this;
    }
    public function getTotalCount()
    {
        return $this->totalCount;
    }
    public function setTotalCount($totalCount)
    {
        $this->totalCount = $totalCount;
        return $this;
    }
}