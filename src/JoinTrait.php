<?php

namespace zabachok\dataProvider;

use yii\db\Query;

trait JoinTrait
{
    private $joinedTables;

    /**
     * @param Query $query
     * @param array $filters
     * @param array $allowedTables
     */
    public function setFilters(Query $query, array $filters, array $allowedTables)
    {
        foreach ($filters as $filter) {
            $this->joinTables($query, $filter->getTables(), $allowedTables);
            $filter->setFilter($query);
        }
    }

    /**
     * @param Query $query
     * @param string[] $tables
     * @param array $allowedTables
     * @throws DataProviderException
     */
    private function joinTables(Query $query, array $tables, array $allowedTables)
    {
        if (empty($tables)) {
            return;
        }

        foreach ($tables as $table) {
            if (!isset($allowedTables[$table])) {
                throw new DataProviderException('`' . $table . '` is not allowed table');
            }
            $this->join($query, $table, $allowedTables[$table]);
        }
    }

    /**
     * @param Query $query
     * @param string $table
     * @param array $options
     */
    private function join(Query $query, string $table, array $options)
    {
        if (in_array($table, $this->joinedTables)) {
            return;
        }

        $this->joinedTables[] = $table;
        $query->join($options['type'], [$options['type'] => $table], $options['on'], $options['params'] ?? null);
    }
}
