<?php

namespace zabachok\dataProvider;

use Yii;

class FilterFactory implements IFilterFactory
{
    /**
     * @var array
     */
    protected $form;

    /**
     * @var IFilterEnum
     */
    private $filterEnum;

    /**
     * @var IFilter[]
     */
    private $filters = [];

    /**
     * @var IFilter[]
     */
    private $totalFilters = [];

    /**
     * @inheritdoc
     */
    public function setForm(array $form): IFilterFactory
    {
        $this->form = $form;
        //reset

        return $this;
    }

    /**
     * @return IFilter[]
     */
    public function getFilters(): array
    {
        if (empty($this->filters)) {
            foreach ($this->filterEnum->getFiltersForRecords() as $filterName) {
                /** @var IFilter $filter */
                $filter = $this->getFilter($filterName);
                if ($filter->isValid()) {
                    $this->filters[] = $filter;
                }
            }
        }

        return $this->filters;
    }

    /**
     * @return IDataFilter[]
     */
    public function getDataFilters(): array
    {
        $result = [];
        foreach ($this->filters as $filter) {
            if($filter instanceof IDataFilter){
                $result[] = $filter;
            }
        }

        return $result;
    }

    /**
     * @param IFilterEnum $filterEnum
     * @return IFilterFactory
     */
    public function setFilterEnum(IFilterEnum $filterEnum): IFilterFactory
    {
        $this->filterEnum = $filterEnum;

        return $this;
    }

    /**
     * @return IFilter[]
     */
    public function getTotalFilters(): array
    {
        if (empty($this->totalFilters)) {
            foreach ($this->filterEnum->getFiltersForTotal() as $filterName) {
                /** @var IFilter $filter */
                $filter = $this->getFilter($filterName);
                if ($filter->isValid()) {
                    $this->totalFilters[] = $filter;
                }
            }
        }

        return $this->totalFilters;
    }

    /**
     * @param string $filterName
     * @return IFilter
     */
    private function getFilter(string $filterName): IFilter
    {
        /** @var IFilter $filter */
        $filter = Yii::$container->get($filterName);

        return $filter->setForm($this->form);
    }
}