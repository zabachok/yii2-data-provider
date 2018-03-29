<?php

namespace app\filters;

interface IFilterRepository
{
    /**
     * @param IFilter[] $filters
     * @param int $pageSize
     * @return array
     */
    public function getRecordsByFilters(array $filters, int $pageSize): array;

    /**
     * @param IFilter[] $filters
     * @return int
     */
    public function getTotalByFilters(array $filters): int;
}