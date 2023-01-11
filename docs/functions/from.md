# Flux Query Builder Docs

## Functions &raquo; from()

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
      <td>settings</td>
      <td>Yes</td>
      <td>array</td>
      <td>Settings to retrieve a data source.</td>
    </tr>
  </tbody>
</table>


### Example

```php
->from([
  'bucket' => 'test_bucket',
  'host' => 'https://us-west-2-1.aws.cloud2.influxdata.com',
  'org' => 'example-org',
  'token' => 'token'
])
```

This will result in the following Flux function part:

```
|> from(
    bucket: "test_bucket",
    host: "https://us-west-2-1.aws.cloud2.influxdata.com",
    org: "example-org",
    token: "token",
)
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/from/)
