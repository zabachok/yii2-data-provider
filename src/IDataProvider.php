<?php

namespace zabachok\dataProvider;

interface IDataProvider
{
    /**
     * @param IFilterEnum $filterEnum
     * @return IDataProvider
     */
    public function setFilterEnum(IFilterEnum $filterEnum): IDataProvider;

    /**
     * @param IFilterRepository $repository
     * @return IDataProvider
     */
    public function setRepository(IFilterRepository $repository): IDataProvider;

    /**
     * @return array
     */
    public function getRecords(): array;

    /**
     * @return int
     */
    public function getTotal(): int;

    /**
     * @return bool
     */
    public function getHasNext(): bool;
}