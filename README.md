# InfluxDB 2.x Flux Query Builder

With this query builder you can build queries for Flux.
See https://docs.influxdata.com/influxdb/v2.3/query-data/flux/

## Installation

```
composer require arendsen/fluxquerybuilder
```

## Example usage

```php
<?php

use Arendsen\FluxQueryBuilder\QueryBuilder;
use Arendsen\FluxQueryBuilder\Expression\KeyValue;

$queryBuilder = new QueryBuilder();
$queryBuilder->fromBucket('test_bucket')
    ->fromMeasurement('test_measurement')
    ->addRangeStart(new DateTime('3 hours ago'))
    ->addFilter(
        KeyValue::setEqualTo('_field', 'username')
            ->orEqualTo('_field', 'email')
    )
    ->addMap('r with name: r.user')
    ->addGroup(['_field', 'ip']);

echo $queryBuilder->build();
```

## Testing

```
composer test
```

## Coding style

Run the following commands to check the coding style. We're using the PSR12 standard.

```
composer check
composer format
```