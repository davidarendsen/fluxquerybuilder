# InfluxDB 2.x Flux Query Builder

With this query builder you can build queries for Flux.
See https://docs.influxdata.com/influxdb/v2.4/query-data/flux/

## Installation

```
composer require arendsen/fluxquerybuilder
```

## Example usage

```php
<?php

use Arendsen\FluxQueryBuilder\QueryBuilder;
use Arendsen\FluxQueryBuilder\Expression\KeyFilter;

$queryBuilder = new QueryBuilder();
$queryBuilder->fromBucket('test_bucket')
    ->addRangeStart(new DateTime('3 hours ago'))
    ->fromMeasurement('test_measurement')
    ->addFieldFilter(['username', 'email'])
    ->addKeyFilter(
        KeyFilter::setEqualTo('_field', 'username')
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

Run the following commands to check and fix the coding style. We're using the PSR12 standard.

```
composer check
composer format
```