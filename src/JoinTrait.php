<?php

namespace zabachok\dataProvider;

use yii\db\Query;

trait JoinTrait
{
    private $joinedTables = [];

    /**
     * @param Query $query
     * @param array $filters
     * @param array $joinTables
     */
    public function setFilters(Query $query, array $filters, array $joinTables)
    {
        $this->joinedTables = [];

        foreach ($filters as $filter) {
            try {

                $this->joinTables($query, $filter->getTables(), $joinTables);
            } catch (DataProviderException $exception) {
                throw new DataProviderException($exception->getMessage() . ' in ' . get_class($filter) . ' filter');
            }
            $filter->setFilter($query);
        }
    }

    /**
     * @param Query $query
     * @param string[] $tables
     * @param array $joinTables
     * @throws DataProviderException
     */
    private function joinTables(Query $query, array $tables, array $joinTables)
    {
        if (empty($tables)) {
            return;
        }

        foreach ($tables as $table) {
            if (!isset($joinTables[$table])) {
                throw new DataProviderException('`' . $table . '` is not allowed table');
            }
            $this->join($query, $table, $joinTables[$table]);
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
        $query->join($options['type'], [$options['alias'] => $table], $options['on'], $options['params'] ?? null);
    }
}
