# Flux Query Builder Docs

## Functions &raquo; addSort()

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
      <td>columns</td>
      <td>Yes</td>
      <td>array</td>
      <td>List of columns to sort by. Default is ["_value"].</td>
    </tr>
  </tbody>
</table>


### Example

```php
->addSort(['column1', 'column2'], true)
```

This will result in the following Flux function part:

```
|> sort(columns: ["column1", "column2"], desc: true)
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/sort/)
