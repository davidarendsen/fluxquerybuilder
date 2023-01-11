# Flux Query Builder Docs

## Functions &raquo; fromMeasurement()

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
      <td>measurement</td>
      <td>Yes</td>
      <td>string</td>
      <td>The measurement to filter on.</td>
    </tr>
  </tbody>
</table>


### Example

```php
->fromMeasurement('test_measurement')
```

This will result in the following Flux function part:

```
|> filter(fn: (r) => r._measurement == "test_measurement")
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/filter/)