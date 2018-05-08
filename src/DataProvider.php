<?php

namespace zabachok\dataProvider;

class DataProvider implements IDataProvider
{
    /**
     * @var FilterFactory
     */
    private $factory;

    /**
     * @var IFilterEnum
     */
    private $filterEnum;

    /**
     * @var IFilterRepository
     */
    private $repository;

    /**
     * @var array
     */
    private $form = [];

    /**
     * @var array
     */
    private $records;

    /**
     * DataProvider constructor.
     * @param IFilterEnum $enum
     * @param IFilterRepository $repository
     * @param FilterFactory $factory
     */
    public function __construct(IFilterEnum $enum, IFilterRepository $repository, FilterFactory $factory)
    {
        $this->factory = $factory;
        $this->filterEnum = $enum;
        $this->factory->setFilterEnum($this->filterEnum);
        $this->repository = $repository;
    }

    /**
     * @return array
     */
    public function getRecords(): array
    {
        $records = $this->getRecordsInternal();
        if($this->getHasNext()){
            array_pop($records);
        }

        $this->setDataToFilters($records);

        return $records;
    }

    /**
     * @return int
     */
    public function getTotal(): int
    {
        return $this->repository->getTotalByFilters(
            $this->factory->getTotalFilters()
        );
    }

    /**
     * @return bool
     */
    public function getHasNext(): bool
    {
        return count($this->getRecordsInternal()) > $this->form['pageSize'];
    }

    /**
     * @param array $form
     */
    public function setForm(array $form): void
    {
        $this->form = $form;

        $this->factory->setForm($form);
    }

    /**
     * @return array
     */
    private function getRecordsInternal(): array
    {
        if(empty($this->records)){
            $this->records = $this->repository->getRecordsByFilters(
                $this->factory->getFilters(), $this->form['pageSize'] + 1
            );
        }

        return $this->records;
    }

    /**
     * @param array $records
     * @return DataProvider
     */
    protected function setDataToFilters(array $records): DataProvider
    {
        $dataFilters = $this->factory->getDataFilters();

        foreach ($dataFilters as $dataFilter) {
            $dataFilter->saveData($records);
        }

        return $this;
    }
}