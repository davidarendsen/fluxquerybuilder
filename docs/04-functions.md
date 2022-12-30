# Flux Query Builder Docs

## Functions

On this page you will find the methods you can use in the query builder.

### addAggregateWindow()

**Parameters:**

<table>
  <tbody>
    <tr>
      <th>Name</th>
      <th>Data type</th>
      <th>Description</th>
      <th>Example</th>
    </tr>
    <tr>
      <td>every</td>
      <td>string</td>
      <td>Duration of time between windows.</td>
      <td>20s</td>
    </tr>
    <tr>
      <td>fn</td>
      <td>string</td>
      <td>Aggregate or selector function to apply to each time window.</td>
      <td>mean</td>
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
      <td>
        <ul>
          <li>period: <i>'every'</i></li>
          <li>offset: <i>'2s'</i></li>
          <li>location: <i>'location'</i></li>
          <li>column: <i>'_value'</i></li>
          <li>timeSrc: <i>'_stop'</i></li>
          <li>timeDst: <i>'_time'</i></li>
          <li>createEmpty: <i>false</i></li>
        </ul>
      </td>
    </tr>

  </tbody>
</table>