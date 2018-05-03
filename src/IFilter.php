<?php

namespace zabachok\dataProvider;

use yii\db\Query;

interface IFilter
{
    /**
     * @param array $form
     * @return IFilter
     */
    public function setForm(array $form): IFilter;

    /**
     * @param Query $query
     * @return Query
     */
    public function setFilter(Query $query): Query;

    /**
     * @return bool
     */
    public function isValid(): bool;

    /**
     * @return string[]
     */
    public function getTables(): array;
}