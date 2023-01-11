# Flux Query Builder Docs

## Functions &raquo; fromBucket()

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
      <td>bucket</td>
      <td>Yes</td>
      <td>string</td>
      <td>The bucket you want to retrieve data from.</td>
    </tr>
  </tbody>
</table>


### Example

```php
->fromBucket('test_bucket')
```

This will result in the following Flux function part:

```
|> from(bucket: "test_bucket")
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/from/)