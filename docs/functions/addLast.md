# Flux Query Builder Docs

## Functions &raquo; addLast()

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
      <td>Column to use to verify the existence of a value. Default is "_value".</td>
    </tr>
  </tbody>
</table>


### Example

```php
->addLast('something')
```

This will result in the following Flux function part:

```
|> last(column: "something")
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/last/)
