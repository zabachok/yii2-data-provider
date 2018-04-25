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

class ProductRepository implements IProductRepository, IFilterRepository
{
    /**
    * @inheritdoc
    */
    public function getRecordsByFilters(array $filters, int $pageSize): array
    {
        $query = Product::find()
            ->limit($pageSize);
            
        foreach($filters as $filter)
        {
            $filter->setFilter($query);
        }
        
        return $query->all();
    }
    
    
    /**
    * @inheritdoc
    */
    public function getTotalByFilters(array $filters): array
    {
        $query = Product::find();
            
        foreach($filters as $filter)
        {
            $filter->setFilter($query);
        }
        
        return $query->count();
    }
}

```

### Enum

```php

class ProductFilterEnum extends BaseEnum implements IFilterEnum
{
    public const 
        PAGINATION_FILTER = 'app\filters\PaginationFilter',
        SIZE_FILTER = 'app\filters\product\SizeFilter',
        COST_FILTER = 'app\filters\product\CostFilter';
        
    /**
    * @inheritdoc
    */
    public function getFiltersForRecords(): array
    {
        return [
            self::PAGINATION_FILTER,
            self::SIZE_FILTER,
            self::COST_FILTER,
        ];
    }
    
    /**
    * @inheritdoc
    */
    public function getFiltersForTotal(): array
    {
        return [
            self::SIZE_FILTER,
            self::COST_FILTER,
        ];
    }
}

```

### Service

```php

class IndexService implements IService
{
    public function __construct()
    {
    
    }
}

```