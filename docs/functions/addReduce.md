# Flux Query Builder Docs

## Functions &raquo; addReduce()

### Parameters:

<table>
  <tbody>
    <tr>
      <th>Name</th>
      <th>Required</th>
      <th>Data type</th>
      <th>Description</th>
    </tr>
    <tr>
      <td>settings</td>
      <td>Yes</td>
      <td>array</td>
      <td>
        Reducer calculation to apply to each row record.
      </td>
    </tr>
    <tr>
      <td>identity</td>
      <td>Yes</td>
      <td>array</td>
      <td>Record that defines the reducer record and provides initial values for the reducer operation on the first row.</td>
    </tr>
  </tbody>
</table>


### Example

```php
use Arendsen\FluxQueryBuilder\Type\MathType;
```

```php
->addReduce([
    [
        'count' => new MathType('accumulator.count + 1'),
    ],
    [
        'count' => 0,
    ]
])
```

This will result in the following Flux function part:

```
|> reduce(fn: (r, accumulator) => ({
    sum: r._value + accumulator.sum
  }), 
  identity: {sum: 0}
)
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/reduce/)
