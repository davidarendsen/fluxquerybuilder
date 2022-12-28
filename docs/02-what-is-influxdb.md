# Flux Query Builder Docs

## What is InfluxDB?

If you're used to working with SQL databases you may need to understand a few concepts. This page will explain some InfluxDB concepts.

InfluxDB is a time-series database. This means the index is a time. This time can be accurate until nanoseconds. This makes it perfect for logging purposes.

### Buckets

Buckets could be seen as databases. They can be configured with a retention time. This can be set from a few minutes until eternity. 

### Measurements

Each bucket can contain multiple measurements. This can be seen as a database table. They hold the actual inserted data.
However the main difference is that they don't have a pre-determined structure. Which means each data insertion can have a different data structure.
