# Flux Query Builder Docs

## Functions &raquo; addMap()

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
      <td>fn</td>
      <td>Yes</td>
      <td>string</td>
      <td>Single argument function to apply to each record. The return value must be a record.</td>
    </tr>
  </tbody>
</table>


### Example

```php
->addMap('r with name: r.user')
```

This will result in the following Flux function part:

```
|> map(fn: (r) => ({ r with name: r.user })) 
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/map/)
