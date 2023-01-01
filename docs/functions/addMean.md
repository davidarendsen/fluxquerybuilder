# Flux Query Builder Docs

## Functions &raquo; addMean()

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
      <td>Yes</td>
      <td>string</td>
      <td>Column to use to compute means. Default is '_value'.</td>
    </tr>
  </tbody>
</table>


### Example

```php
->addMean('test')
```

This will result in the following Flux function part:

```
|> mean(column: "test")
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/mean/)
