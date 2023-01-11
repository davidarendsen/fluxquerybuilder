# Flux Query Builder Docs

## Functions &raquo; addRangeInBetween()

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
      <td>start</td>
      <td>Yes</td>
      <td>DateTime</td>
      <td>Earliest time to include in results.</td>
    </tr>
    <tr>
      <td>stop</td>
      <td>Yes</td>
      <td>DateTime</td>
      <td>Latest time to include in results. Default is the current time.</td>
    </tr>
  </tbody>
</table>


### Example

```php
->addRangeInBetween(
    new DateTime('2022-08-12 18:00:00'),
    new DateTime('2022-08-12 20:00:00')
)
```

This will result in the following Flux function part:

```
|> range(
  start: time(v: 2022-08-12T18:00:00Z), 
  stop: time(v: 2022-08-12T20:00:00Z)
)
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/range/)