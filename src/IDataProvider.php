<?php

namespace zabachok\dataProvider;

interface IDataProvider
{
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