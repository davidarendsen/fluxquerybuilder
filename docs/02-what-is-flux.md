# Flux Query Builder Docs

## What is Flux?

Since InfluxDB2 they introduced this new Flux query language. Coming from a SQL database background this is a totally new concept and language to learn.

### Example Flux query:
```js
from(bucket: "example-bucket")
    |> range(start: -1h)
    |> filter(fn: (r) => 
        r._measurement == "example-measurement" 
        and r.tag == "example-tag"
    )
    |> filter(fn: (r) => r._field == "example-field")
```