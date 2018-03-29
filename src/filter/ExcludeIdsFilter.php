<?php

namespace app\filters\universal;

use app\filters\DataFilter;
use yii\db\Query;

class ExcludeIdsFilter extends DataFilter
{
    /**
     * @var string
     */
    private $alias = '';

    /**
     * @param string $alias
     * @return ExcludeIdsFilter
     */
    public function setAlias(string $alias): ExcludeIdsFilter
    {
        $this->alias = $alias;

        return $this;
    }

    /**
     * @param array $data
     * @return mixed
     */
    protected function formatData(array $data)
    {
        $productIds = array_column($data, 'id');
        $cacheProductIds = $this->getDataFromCache() ?: [];
        $excludeProductIds = array_merge($cacheProductIds, $productIds);

        return $excludeProductIds;
    }

    /**
     * @param Query $query
     * @return Query
     */
    public function setFilter(Query $query): Query
    {
        if ($ids = $this->getDataFromCache()) {
            $query->andWhere(['not in', $this->alias . 'id', $ids]);
        }

        return $query;
    }

    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return true;
    }
}