<?php

namespace zabachok\dataProvider;

interface IFilterEnum
{
    /**
     * @return string[]
     */
    public function getFiltersForRecords(): array;

    /**
     * @return string[]
     */
    public function getFiltersForTotal(): array;
}