# Flux Query Builder Docs

## Functions &raquo; addFirst()

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
      <td>Column to operate on. Default is '_value'.</td>
    </tr>
  </tbody>
</table>


### Example

```php
->addFirst("_value")
```

This will result in the following Flux function part:

```
|> first(column: "_value")
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/first/)
