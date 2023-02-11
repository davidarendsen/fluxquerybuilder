# Flux Query Builder Docs

## Functions &raquo; addWindow()

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
      <td>every</td>
      <td>Yes</td>
      <td>string</td>
      <td>Duration of time between windows.</td>
    </tr>
    <tr>
      <td>options</td>
      <td>No</td>
      <td>array</td>
      <td>
        <ul>
          <li>
            period (string): <i>Duration of windows. Default is the 'every' value.</i>
          </li>
          <li>
            offset (string): <i>Duration to shift the window boundaries by. Default is '0s'.</i>
          </li>
          <li>
            location (string): <i>Location used to determine timezone. Default is the 'location' option.</i>
          </li>
          <li>
            timeColumn (string): <i>Column that contains time values. Default is '_time'.</i>
          </li>
          <li>
            startColumn (string): <i>Column to store the window start time in. Default is '_start'.</i>
          </li>
          <li>
            stopColumn (string): <i>Column to store the window stop time in. Default is '_stop'.</i>
          </li>
          <li>
            createEmpty (boolean): <i>Create empty tables for empty window. Default is false.</i>
          </li>
        </ul>
      </td>
    </tr>
  </tbody>
</table>


### Example

```php
->addWindow('20s', [
  'timeColumn' => '_time',
])
```

This will result in the following Flux function part:

```
|> window(every: 20s, timeColumn: "_time")
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/window/)
