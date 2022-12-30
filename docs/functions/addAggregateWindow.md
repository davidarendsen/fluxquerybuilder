# Flux Query Builder Docs

## Functions &raquo; addAggregateWindow()

### Parameters:

<table>
  <tbody>
    <tr>
      <th>Name</th>
      <th>Data type</th>
      <th>Description</th>
    </tr>
    <tr>
      <td>every</td>
      <td>string</td>
      <td>Duration of time between windows.</td>
    </tr>
    <tr>
      <td>fn</td>
      <td>string</td>
      <td>Aggregate or selector function to apply to each time window.</td>
    </tr>
    <tr>
      <td>options</td>
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
            column (string): <i>Column to operate on.</i>
          </li>
          <li>
            timeSrc (string): <i>Column to use as the source of the new time value for aggregate values. Default is '_stop'.</i>
          </li>
          <li>
            timeDst (string): <i>Column to store time values for aggregate values in. Default is '_time'.</i>
          </li>
          <li>
            createEmpty (boolean): <i>Create empty tables for empty window. Default is true.</i>
          </li>
        </ul>
      </td>
    </tr>

  </tbody>
</table>


### Example

```php
->addAgregateWindow('20s', 'mean', [
    'period' => 'every',
    'offset' => '2s',
    'location' => 'location',
    'column' => '_value',
    'timeSrc' => '_stop',
    'timeDst' => '_time',
    'createEmpty' => false,
])
```

This will result in the following Flux function part:

```
|> aggregateWindow(
    every: 20s,
    period: every,
    offset: 0s,
    fn: mean,
    location: "location",
    column: "_value", 
    timeSrc: "_stop", 
    timeDst: "_time", 
    createEmpty: false
)
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/aggregatewindow/)