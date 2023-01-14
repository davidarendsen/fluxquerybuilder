<?php

namespace Arendsen\FluxQueryBuilder\Builder;

class FluxPart
{
    public const FROM = 'from';
    public const MEASUREMENT = 'measurement';
    public const RANGE = 'range';
    public const FILTERS = 'filters';
    public const REDUCE = 'reduce';
    public const MAP = 'map';
    public const SORT = 'sort';
    public const GROUP = 'group';
    public const LIMIT = 'limit';
    public const WINDOW = 'window';
    public const MEAN = 'mean';
    public const DUPLICATE = 'duplicate';
    public const UNWINDOW = 'unwindow';
    public const AGGREGATEWINDOW = 'aggregateWindow';
    public const RAWFUNCTION = 'raw';
}
