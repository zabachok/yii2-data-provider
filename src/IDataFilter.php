<?php

namespace zabachok\dataProvider;

interface IDataFilter extends IFilter
{
    /**
     * @param array $data
     * @return bool
     */
    public function saveData(array $data): bool;
}