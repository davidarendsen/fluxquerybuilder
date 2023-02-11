# Flux Query Builder Docs

## Functions &raquo; addUnwindow()

Keeping aggregate values in separate tables generally isn’t the format in which you want your data. Use the window() function to “unwindow” your data into a single infinite (inf) window.

### Example

```php
->addUnwindow()
```

This will result in the following Flux function part:

```
|> window(every: inf)
```

### Extra resources

* [Flux documentation](https://docs.influxdata.com/flux/v0.x/stdlib/universe/window/)
