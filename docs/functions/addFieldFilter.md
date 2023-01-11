# Flux Query Builder Docs

## Functions &raquo; addFieldFilter()

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
      <td>fields</td>
      <td>Yes</td>
      <td>array</td>
      <td>
        The fields you want to have a filter on.
      </td>
    </tr>
  </tbody>
</table>


### Example

```php
->addFieldFilter(['field1', 'field2'])
```

This will result in the following Flux function part:

```
|> filter(fn: (r) => 
    r._field == "field1" or r._field == "field2"
)
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/filter/)
