# Flux Query Builder Docs

## Getting started

Install the package with composer:
```
composer require arendsen/fluxquerybuilder
```

The most basic Flux query can be made with the following code. It has filters for fields and tags.

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
        KeyFilter::setEqualTo('username', 'David')
            ->andEqualTo('email', 'david@example.com')
    )
    ->limit(50, 100);

echo $queryBuilder->build();
```

Which will result in the following Flux query:

```js
from(bucket: "test_bucket") 
    |> range(start: time(v: 2022-12-28T13:21:11Z)) 
    |> filter(fn: (r) => r._measurement == "test_measurement") 
    |> filter(fn: (r) => 
        r._field == "username" or r._field == "email"
    ) 
    |> filter(fn: (r) => 
        r.username == "David" and r.email == "david@example.com"
    ) 
    |> limit(n: 50, offset: 100)
```

For a deeper dive into the possible methods of the Query builder you can check [this page](04-functions.md).