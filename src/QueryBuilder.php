<?php

namespace Arendsen\FluxQueryBuilder;

use DateTime;
use Exception;
use Arendsen\FluxQueryBuilder\Expression\KeyValue;
use Arendsen\FluxQueryBuilder\Functions\AggregateWindow;
use Arendsen\FluxQueryBuilder\Functions\Filter;
use Arendsen\FluxQueryBuilder\Functions\From;
use Arendsen\FluxQueryBuilder\Functions\Range;
use Arendsen\FluxQueryBuilder\Functions\Reduce;
use Arendsen\FluxQueryBuilder\Functions\Sort;
use Arendsen\FluxQueryBuilder\Functions\Map;
use Arendsen\FluxQueryBuilder\Functions\Group;
use Arendsen\FluxQueryBuilder\Functions\Limit;
use Arendsen\FluxQueryBuilder\Functions\Window;

class QueryBuilder
{
    public const FLUX_PART_FROM = 'from';
    public const FLUX_PART_RANGE = 'range';
    public const FLUX_PART_FILTERS = 'filters';
    public const FLUX_PART_REDUCE = 'reduce';
    public const FLUX_PART_MAP = 'map';
    public const FLUX_PART_SORT = 'sort';
    public const FLUX_PART_GROUP = 'group';
    public const FLUX_PART_LIMIT = 'limit';
    public const FLUX_PART_WINDOW = 'window';
    public const FLUX_PART_UNWINDOW = 'unwindow';
    public const FLUX_PART_AGGREGATEWINDOW = 'aggregateWindow';

    public const PARTS = [
        self::FLUX_PART_FROM,
        self::FLUX_PART_RANGE,
        self::FLUX_PART_REDUCE,
        self::FLUX_PART_AGGREGATEWINDOW,
        self::FLUX_PART_WINDOW,
        self::FLUX_PART_FILTERS,
        self::FLUX_PART_MAP,
        self::FLUX_PART_SORT,
        self::FLUX_PART_GROUP,
        self::FLUX_PART_LIMIT,
        self::FLUX_PART_UNWINDOW,
    ];

    public const REQUIRED_INPUT_FROM = 'from';
    public const REQUIRED_INPUT_MEASUREMENT = 'measurement';
    public const REQUIRED_INPUT_RANGE = 'range';

    public const REQUIRED_INPUT = [
        self::REQUIRED_INPUT_FROM,
        self::REQUIRED_INPUT_MEASUREMENT,
        self::REQUIRED_INPUT_RANGE,
    ];

    /**
     * @var array $fluxQuery
     */
    private $fluxQueryParts = [];

    /**
     * @var array $requiredData
     */
    private $requiredData = [];

    public function from(array $from): QueryBuilder
    {
        $this->addRequiredData(self::REQUIRED_INPUT_FROM, $from);
        $this->addToQuery(
            self::FLUX_PART_FROM,
            new From($from)
        );
        return $this;
    }

    public function fromBucket(string $bucket): QueryBuilder
    {
        $this->from(['bucket' => $bucket]);
        return $this;
    }

    public function fromMeasurement(string $measurement): QueryBuilder
    {
        $this->addRequiredData(self::REQUIRED_INPUT_MEASUREMENT, $measurement);
        $this->addToQueryArray(
            self::FLUX_PART_FILTERS,
            new Filter(KeyValue::setEqualTo('_measurement', $measurement))
        );
        return $this;
    }

    public function addFilter(KeyValue $keyValue): QueryBuilder
    {
        $this->addToQueryArray(
            self::FLUX_PART_FILTERS,
            new Filter($keyValue)
        );
        return $this;
    }

    public function addFieldFilter(array $fields): QueryBuilder
    {
        $this->addToQueryArray(
            self::FLUX_PART_FILTERS,
            new Filter($fields)
        );
        return $this;
    }

    public function addRange(DateTime $start, ?DateTime $stop = null): QueryBuilder
    {
        $this->addRequiredData(self::REQUIRED_INPUT_RANGE, [$start, $stop]);
        $this->addToQuery(
            self::FLUX_PART_RANGE,
            new Range($start, $stop)
        );
        return $this;
    }

    public function addRangeStart(DateTime $start): QueryBuilder
    {
        $this->addRange($start);
        return $this;
    }

    public function addRangeInBetween(DateTime $start, DateTime $stop)
    {
        $this->addRange($start, $stop);
        return $this;
    }

    public function addReduce(array $settings, array $identity): QueryBuilder
    {
        $this->addToQueryArray(
            self::FLUX_PART_REDUCE,
            new Reduce($settings, $identity)
        );
        return $this;
    }

    public function addSort(array $columns, $desc): QueryBuilder
    {
        $this->addToQueryArray(
            self::FLUX_PART_SORT,
            new Sort($columns, $desc)
        );
        return $this;
    }

    public function addMap(string $query): QueryBuilder
    {
        $this->addToQueryArray(
            self::FLUX_PART_MAP,
            new Map($query)
        );
        return $this;
    }

    public function addGroup(array $columns, $mode = 'by'): QueryBuilder
    {
        $this->addToQueryArray(
            self::FLUX_PART_GROUP,
            new Group($columns, $mode)
        );
        return $this;
    }

    public function addLimit(int $limit): QueryBuilder
    {
        $this->addToQueryArray(
            self::FLUX_PART_LIMIT,
            new Limit($limit)
        );
        return $this;
    }

    public function addWindow(
        $every,
        ?string $period = null,
        ?string $offset = null,
        ?string $location = null,
        ?string $timeColumn = null,
        ?string $startColumn = null,
        ?string $stopColumn = null,
        bool $createEmpty = false
    ): QueryBuilder {
        $this->addToQueryArray(
            self::FLUX_PART_WINDOW,
            new Window($every, $period, $offset, $location, $timeColumn, $startColumn, $stopColumn, $createEmpty)
        );
        return $this;
    }

    public function addUnWindow()
    {
        $this->addToQueryArray(
            self::FLUX_PART_UNWINDOW,
            new Window('inf')
        );
        return $this;
    }

    public function addAggregateWindow(
        $every,
        ?string $period = null,
        ?string $offset = null,
        $fn,
        ?string $location = null,
        ?string $column = null,
        ?string $timeSrc = null,
        ?string $timeDst = null,
        bool $createEmpty = true
    ): QueryBuilder {
        $this->addToQuery(
            self::FLUX_PART_AGGREGATEWINDOW,
            new AggregateWindow($every, $period, $offset, $fn, $location, $column, $timeSrc, $timeDst, $createEmpty)
        );
        return $this;
    }

    protected function addToQuery($key, $query)
    {
        $this->fluxQueryParts[$key] = $query;
    }

    protected function addToQueryArray($key, $query)
    {
        $this->fluxQueryParts[$key][] = $query;
    }

    public function build(): string
    {
        $this->checkRequired();

        $query = '';

        foreach (self::PARTS as $part) {
            if (isset($this->fluxQueryParts[$part])) {
                if (is_array($this->fluxQueryParts[$part])) {
                    foreach ($this->fluxQueryParts[$part] as $filter) {
                        $query .= $filter;
                    }
                } else {
                    $query .= $this->fluxQueryParts[$part];
                }
            }
        }

        return $query;
    }

    protected function addRequiredData(string $key, $value)
    {
        $this->requiredData[$key] = $value;
    }

    protected function checkRequired()
    {
        foreach (self::REQUIRED_INPUT as $input) {
            if (!isset($this->requiredData[$input])) {
                throw new Exception('You need to define the "' . $input . '" part of the query!');
            }
        }
    }
}
