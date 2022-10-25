<?php

namespace Arendsen\FluxQueryBuilder;

use DateTime;
use Exception;
use Arendsen\FluxQueryBuilder\Expression\KeyValue;
use Arendsen\FluxQueryBuilder\Expression\KeyFilter;
use Arendsen\FluxQueryBuilder\Functions\AggregateWindow;
use Arendsen\FluxQueryBuilder\Functions\Duplicate;
use Arendsen\FluxQueryBuilder\Functions\Filter;
use Arendsen\FluxQueryBuilder\Functions\From;
use Arendsen\FluxQueryBuilder\Functions\Range;
use Arendsen\FluxQueryBuilder\Functions\Reduce;
use Arendsen\FluxQueryBuilder\Functions\Sort;
use Arendsen\FluxQueryBuilder\Functions\Map;
use Arendsen\FluxQueryBuilder\Functions\Group;
use Arendsen\FluxQueryBuilder\Functions\Limit;
use Arendsen\FluxQueryBuilder\Functions\Mean;
use Arendsen\FluxQueryBuilder\Functions\RawFunction;
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
    public const FLUX_PART_MEAN = 'mean';
    public const FLUX_PART_DUPLICATE = 'duplicate';
    public const FLUX_PART_UNWINDOW = 'unwindow';
    public const FLUX_PART_AGGREGATEWINDOW = 'aggregateWindow';
    public const FLUX_PART_RAWFUNCTION = 'raw';

    public const REQUIRED_INPUT_FROM = 'from';
    public const REQUIRED_INPUT_RANGE = 'range';
    public const REQUIRED_INPUT_MEASUREMENT = 'measurement';

    public const REQUIRED_INPUT = [
        self::REQUIRED_INPUT_FROM,
        self::REQUIRED_INPUT_RANGE,
        self::REQUIRED_INPUT_MEASUREMENT,
    ];

    /**
     * @var int $currentFluxQueryPart
     */
    private $currentFluxQueryPart = 0;

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
        $this->addKeyFilter(KeyFilter::setEqualTo('_measurement', $measurement));
        return $this;
    }

    /**
     * @deprecated
     *
     * @param KeyValue $keyValue
     * @return QueryBuilder
     */
    public function addFilter(KeyValue $keyValue): QueryBuilder
    {
        $this->addToQuery(
            self::FLUX_PART_FILTERS,
            new Filter($keyValue)
        );
        return $this;
    }

    public function addKeyFilter(KeyFilter $keyFilter): QueryBuilder
    {
        $this->addToQuery(
            self::FLUX_PART_FILTERS,
            new Filter($keyFilter)
        );
        return $this;
    }

    public function addFieldFilter(array $fields): QueryBuilder
    {
        $this->addToQuery(
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
        $this->addToQuery(
            self::FLUX_PART_REDUCE,
            new Reduce($settings, $identity)
        );
        return $this;
    }

    public function addSort(array $columns, $desc): QueryBuilder
    {
        $this->addToQuery(
            self::FLUX_PART_SORT,
            new Sort($columns, $desc)
        );
        return $this;
    }

    public function addMap($query): QueryBuilder
    {
        $this->addToQuery(
            self::FLUX_PART_MAP,
            new Map($query)
        );
        return $this;
    }

    public function addGroup(array $columns, $mode = 'by'): QueryBuilder
    {
        $this->addToQuery(
            self::FLUX_PART_GROUP,
            new Group($columns, $mode)
        );
        return $this;
    }

    public function addLimit(int $limit): QueryBuilder
    {
        $this->addToQuery(
            self::FLUX_PART_LIMIT,
            new Limit($limit)
        );
        return $this;
    }

    public function addWindow($every, array $options = []): QueryBuilder
    {
        $this->addToQuery(
            self::FLUX_PART_WINDOW,
            new Window($every, $options)
        );
        return $this;
    }

    public function addDuplicate(string $column, string $as): QueryBuilder
    {
        $this->addToQuery(
            self::FLUX_PART_DUPLICATE,
            new Duplicate($column, $as)
        );
        return $this;
    }

    public function addMean(?string $column = ''): QueryBuilder
    {
        $this->addToQuery(
            self::FLUX_PART_MEAN,
            new Mean($column)
        );
        return $this;
    }

    public function addUnWindow(): QueryBuilder
    {
        $this->addToQuery(
            self::FLUX_PART_UNWINDOW,
            new Window('inf')
        );
        return $this;
    }

    public function addAggregateWindow($every, $fn, array $options = []): QueryBuilder
    {
        $this->addToQuery(
            self::FLUX_PART_AGGREGATEWINDOW,
            new AggregateWindow($every, $fn, $options)
        );
        return $this;
    }

    public function addRawFunction(string $input): QueryBuilder
    {
        $this->addToQuery(
            self::FLUX_PART_RAWFUNCTION,
            new RawFunction($input)
        );
        return $this;
    }

    protected function addToQuery($key, $query)
    {
        $this->fluxQueryParts[$this->currentFluxQueryPart] = $query;
        $this->currentFluxQueryPart++;
    }

    public function build(): string
    {
        $this->checkRequired();

        $query = '';

        foreach ($this->fluxQueryParts as $part) {
            $query .= $part;
        }

        return $query;
    }

    protected function addRequiredData(string $key, $value)
    {
        $this->requiredData[][$key] = $value;
    }

    protected function checkRequired()
    {
        foreach (self::REQUIRED_INPUT as $key => $input) {
            if (!isset($this->requiredData[$key][$input])) {
                throw new Exception('You need to define the "' . $input . '" part of the query!');
            }
        }
    }
}
