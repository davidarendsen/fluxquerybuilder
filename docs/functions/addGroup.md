# Flux Query Builder Docs

## Functions &raquo; addGroup()

### Parameters:

<table>
  <tbody>
    <tr>
      <th>Name</th>
      <th>Data type</th>
      <th>Description</th>
    </tr>
    <tr>
      <td>columns</td>
      <td>array</td>
      <td>List of columns to use in the grouping operation.</td>
    </tr>
    <tr>
      <td>mode</td>
      <td>string</td>
      <td>Grouping mode. Default is 'by'.</td>
    </tr>

  </tbody>
</table>


### Example

```php
->addGroup(['foo', 'bar'], 'by')
```

This will result in the following Flux function part:

```
|> group(
    columns: ["foo", "bar"],
    mode: "by"
)
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/group/)
