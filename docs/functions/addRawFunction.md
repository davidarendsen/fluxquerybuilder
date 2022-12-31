# Flux Query Builder Docs

## Functions &raquo; addRawFunction()

### Parameters:

<table>
  <tbody>
    <tr>
      <th>Name</th>
      <th>Data type</th>
      <th>Description</th>
    </tr>
    <tr>
      <td>input</td>
      <td>string</td>
      <td>Insert any Flux function here.</td>
    </tr>
  </tbody>
</table>


### Example

```php
->addRawFunction('|> aggregateWindow(every: 20s, fn: mean, timeDst: "_time")')
```

This will result in the following Flux function part:

```
|> aggregateWindow(every: 20s, fn: mean, timeDst: "_time")
```
