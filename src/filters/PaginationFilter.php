<?php

namespace zabachok\dataProvider\filters;

use zabachok\dataProvider\Filter;
use yii\db\Query;

class PaginationFilter extends Filter
{
    /**
     * @param Query $query
     * @return Query
     */
    public function setFilter(Query $query): Query
    {
        $pageSize = $this->form['pageSize'] ?? 20;
        $page = $this->form['page'] ?? 0;

        return $query->limit($pageSize)
            ->offset($pageSize * $page);
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return true;
    }
}