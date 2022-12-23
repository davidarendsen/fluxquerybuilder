# InfluxDB 2.x Flux Query Builder

With this query builder you can build queries for Flux.

[Check our documentation](docs/00-index.md)

## Installation

```
composer require arendsen/fluxquerybuilder
```

## Example usage

```php
<?php

use Arendsen\FluxQueryBuilder\QueryBuilder;
use Arendsen\FluxQueryBuilder\Expression\KeyFilter;
use Arendsen\FluxQueryBuilder\Expression\Map;
use Arendsen\FluxQueryBuilder\Expression\Selection;

$queryBuilder = new QueryBuilder();
$queryBuilder->fromBucket('test_bucket')
    ->addRangeStart(new DateTime('3 hours ago'))
    ->fromMeasurement('test_measurement')
    ->addFieldFilter(['username', 'email'])
    ->addKeyFilter(
        KeyFilter::setEqualTo('_field', 'username')
            ->orEqualTo('_field', 'email')
    )
    ->addMap(Map::with('name', 'user'))
    ->addMap(Map::columns([
        'time' => '_time',
        'source' => 'tag',
        'alert' => Selection::if('r._value > 10')->then(true)->else(false),
        'test' => Selection::if('r._value > 10')->then('yes')->else('no'),
    ]))
    ->addGroup(['_field', 'ip']);

echo $queryBuilder->build();
```

## Testing

```
composer test
```

## Coding style

Run the following commands to check and fix the coding style. We're using the PSR12 standard.

```
composer check
composer format
```