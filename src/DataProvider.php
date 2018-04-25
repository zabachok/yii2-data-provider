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

    /**
     * @param array $form
     */
    public function setForm(array $form): void
    {
        $this->factory->setForm($form);
    }
}