# Flux Query Builder Docs

## Functions &raquo; addDuplicate()

### Parameters:

<table>
  <tbody>
    <tr>
      <th>Name</th>
      <th>Data type</th>
      <th>Description</th>
    </tr>
    <tr>
      <td>column</td>
      <td>string</td>
      <td>Column to duplicate.</td>
    </tr>
    <tr>
      <td>as</td>
      <td>string</td>
      <td>Name to assign to the duplicate column.</td>
    </tr>

  </tbody>
</table>


### Example

```php
->addDuplicate('tag', 'tag_dup')
```

This will result in the following Flux function part:

```
|> duplicate(
    column: "tag",
    as: "tag_dup",
)
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/duplicate/)
