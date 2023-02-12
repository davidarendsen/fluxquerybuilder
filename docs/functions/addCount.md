# Flux Query Builder Docs

## Functions &raquo; addCount()

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
      <td>column</td>
      <td>No</td>
      <td>string</td>
      <td>Column to count values in and store the total count.</td>
    </tr>
  </tbody>
</table>


### Example

```php
->addCount("_value")
```

This will result in the following Flux function part:

```
|> count(column: "_value")
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/count/)
