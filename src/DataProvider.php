<?php

namespace zabachok\dataProvider;

class DataProvider implements IDataProvider
{
    /**
     * @var IFilterFactory
     */
    private $factory;

    /**
     * DataProvider constructor.
     * @param IFilterFactory $factory
     */
    public function __construct(IFilterFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @var IFilterEnum
     */
    private $filterEnum;

    /**
     * @var IFilterRepository
     */
    private $repository;

    /**
     * @param IFilterEnum $filterEnum
     * @return IDataProvider
     */
    public function setFilterEnum(IFilterEnum $filterEnum): IDataProvider
    {
        $this->filterEnum = $filterEnum;
        $this->factory->setFilterEnum($this->filterEnum);

        return $this;
    }

    /**
     * @param IFilterRepository $repository
     * @return IDataProvider
     */
    public function setRepository(IFilterRepository $repository): IDataProvider
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * @return array
     */
    public function getRecords(): array
    {
        // TODO: Implement getRecords() method.
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
        // TODO: Implement getHasNext() method.
    }
}