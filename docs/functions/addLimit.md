# Flux Query Builder Docs

## Functions &raquo; addLimit()

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
      <td>n</td>
      <td>Yes</td>
      <td>integer</td>
      <td>Maximum number of rows to return.</td>
    </tr>
    <tr>
      <td>offset</td>
      <td>No</td>
      <td>integer</td>
      <td>Number of rows to skip per table before limiting to <u>n</u>. Default is 0.</td>
    </tr>

  </tbody>
</table>


### Example

```php
->addLimit(20, 40)
```

This will result in the following Flux function part:

```
|> limit(
    n: 20,
    offset: 40
)
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/limit/)
