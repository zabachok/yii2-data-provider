# Yii2 Data Provider

Library for getting data from repository by filters. 

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require zabachok/yii2-data-provider "*"
```

or add

```
"zabachok/yii2-data-provider": "*"
```

to the require section of your `composer.json` file.

## Examples

### Repository

```php

namespace app\repositories\statistic;

use app\models\statistic\StatisticExportRequest;
use app\repositories\statistic\dto\RequestDto;
use zabachok\dataProvider\IFilterRepository;

class StatisticRepository implements IStatisticRepository, IFilterRepository
{
    /**
     * @inheritdoc
     * @return RequestDto[]
     */
    public function getRecordsByFilters(array $filters, int $pageSize): array
    {
        $query = StatisticExportRequest::find()
            ->limit($pageSize);

        foreach ($filters as $filter) {
            $filter->setFilter($query);
        }

        $models = $query->all();

        return $this->getRequestDtos($models);
    }

    /**
     * @inheritdoc
     */
    public function getTotalByFilters(array $filters): int
    {
        $query = StatisticExportRequest::find();

        foreach ($filters as $filter) {
            $filter->setFilter($query);
        }

        return $query->count();
    }
    
    ...

```

### Enum

```php

namespace app\enums\statistic;

use app\filters\statistic\CreatedAtOrderFilter;
use zabachok\dataProvider\filters\PaginationFilter;
use zabachok\dataProvider\IFilterEnum;

class FiltersEnum implements IFilterEnum
{
    public const
        PAGINATION_FILTER = PaginationFilter::class,
        CREATED_AT_ORDER_FILTER = CreatedAtOrderFilter::class;
        
    /**
     * @inheritdoc
     */
    public function getFiltersForRecords(): array
    {
        return [
            self::PAGINATION_FILTER,
            self::CREATED_AT_ORDER_FILTER,
        ];
    }

    /**
     * @inheritdoc
     */
    public function getFiltersForTotal(): array
    {
        return [
            self::CREATED_AT_ORDER_FILTER,
        ];
    }
}

```

### Service

```php

namespace app\services\statistic;

use app\builders\IBuilder;
use app\builders\statistic\IndexBuilder;
use app\components\enums\statistic\FiltersEnum;
use app\forms\statistic\IndexForm;
use app\repositories\statistic\IStatisticRepository;
use app\repositories\statistic\StatisticRepository;
use app\services\IService;
use Yii;
use yii\base\Model;
use zabachok\dataProvider\DataProvider;

class IndexService implements IService
{
    /**
     * @var DataProvider
     */
    private $dataProvider;

    /**
     * @var IndexBuilder
     */
    private $builder;

    /**
     * IndexService constructor.
     * @param StatisticRepository $repository
     * @param FiltersEnum $filtersEnum
     * @param IndexBuilder $builder
     */
    public function __construct(
        StatisticRepository $repository,
        FiltersEnum $filtersEnum,
        IndexBuilder $builder
    ) {
        $this->dataProvider = Yii::$container->get(DataProvider::class, [$filtersEnum, $repository]);
        $this->builder = $builder;
    }

    /**
     * @param Model|IndexForm $form
     * @return IBuilder
     */
    public function behave(Model $form): IBuilder
    {
        $this->dataProvider->setForm($form->toArray());

        $this->builder
            ->addItems(
                $this->dataProvider->getRecords()
            )
            ->setTotal(
                $this->dataProvider->getTotal()
            );

        return $this->builder;
    }
}

```