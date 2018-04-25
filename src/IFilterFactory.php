<?php

namespace zabachok\dataProvider;

interface IFilterFactory
{
    /**
     * @param IFilterEnum $filterEnum
     * @return IFilterFactory
     */
    public function setFilterEnum(IFilterEnum $filterEnum): IFilterFactory;

    /**
     * @return IFilter[]
     */
    public function getFilters(): array;

    /**
     * @return IDataFilter[]
     */
    public function getDataFilters(): array;

    /**
     * @return IFilter[]
     */
    public function getTotalFilters(): array;
}