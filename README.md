# Garlic Helpers

## Install

Via Composer

``` bash
$ composer require garlic/helpers
```

## Collection
_Garlic\Helpers\Collection_ imports and extends [Laravel's Collections](https://laravel.com/docs/5.8/collections).
 
## Array helper
_Garlic\Helpers\ArrayHelper_  extends [Laravel's Array helper](https://laravel.com/docs/5.8/helpers#available-methods)
and adds some features, like:

_ArrayHelper::groupBy(array $array, $key)_ group the array by given keys.

```php
use Garlic\Helpers\ArrayHelper;

$geoObjects = [
    [
        'state' => 'IN',
        'city' => 'Indianapolis',
        'object' => 'School bus',
    ],
    [
        'state' => 'IN',
        'city' => 'Indianapolis',
        'object' => 'Manhole',
    ],
    [
        'state' => 'IN',
        'city' => 'Plainfield',
        'object' => 'Basketball',
    ],
];

$items = ArrayHelper::groupBy($geoObjects, 'state', 'city');
```
or using callback:

```php
$items = ArrayHelper::groupBy($geoObjects, function($item) {
    return $item['city'];
});
```

_ArrayHelper::mapByKeys(array $array, array $mapKeys)_ mapping the array by given mapKeys.
```php
use Garlic\Helpers\ArrayHelper;

$user = [
    'id' => 4456,
    'first_name' => 'Ivan',
    'salary' => 990,
    'password_hash' => 'lTTxJL8973onRl93a8m31AW6mdCsrzU8',
];

$result = ArrayHelper::mapByKeys($user, ['id', 'first_name' => 'name', 'salary']);

// ['id' => '4456', 'name' => 'Ivan', 'salary' => '990']
```

_ArrayHelper::onlyValues(array $array, $values)_ filter array by given values,
_ArrayHelper::exceptValues(array $array, $values)_ remove array items by given values,
```php
use Garlic\Helpers\ArrayHelper;

$items = [100, 'amount' => 100, 300, 'count' => 200,];
$result = ArrayHelper::onlyValues($items, [100, 200]);

// [0 => 100, 'amount' => 100, 'count' => 200]
```

_ArrayHelper::flattenWithPath(array $array)_  flatten a multidimensional array into a single level array with dot notation path as keys.
```php
use Garlic\Helpers\ArrayHelper;

$geoObjects = [
    [
        'state' => 'IN',
        'city' => 'Indianapolis',
        'object' => 'School bus',
    ],
    [
        'state' => 'IN',
        'city' => 'Plainfield',
        'object' => 'Basketball',
    ],
];

$result = ArrayHelper::flattenWithPath($geoObjects);
/*
[
    '0.state' => 'IN',
    '0.city' => 'Indianapolis',
    '0.object' => 'School bus',
    '1.state' => 'IN',
    '1.city' => 'Plainfield',
    '1.object' => 'Basketball',
]
*/
```

```php
use Garlic\Helpers\ArrayHelper;

// Returns true, if a given item is last one of the array
ArrayHelper::isLast(array $array, $item)

// Returns true, if a given item is first one of the array
ArrayHelper::isFirst(array $array, $item)

// Remove null items from array
ArrayHelper::removeNull(array $array)
```


