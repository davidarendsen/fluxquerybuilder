# Flux Query Builder Docs

## Functions &raquo; addBottom()

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
      <td>string</td>
      <td>Number of rows to return from each input table.</td>
    </tr>
    <tr>
      <td>columns</td>
      <td>No</td>
      <td>array</td>
      <td>List of columns to sort by. Default is ["_value"].</td>
    </tr>
  </tbody>
</table>


### Example

```php
->addBottom(2, ['_value'])
```

This will result in the following Flux function part:

```
|> bottom(n: 2, columns: ["_value"])
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/bottom/)
