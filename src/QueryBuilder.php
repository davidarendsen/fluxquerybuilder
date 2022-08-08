<?php

namespace Arendsen\FluxQueryBuilder;

use Arendsen\FluxQueryBuilder\Expression\KeyValue;
use Arendsen\FluxQueryBuilder\Function\Filter;
use Arendsen\FluxQueryBuilder\Function\From;
use Arendsen\FluxQueryBuilder\Function\Range;
use Exception;

class QueryBuilder {

    const FLUX_PART_FROM = 'from';
    const FLUX_PART_RANGE = 'range';
    const FLUX_PART_FILTERS = 'filters';

    /**
     * @var array $fluxQuery
     */
    private $fluxQueryParts = [];

    /**
     * @var array $from
     */
    private $from;

    /**
     * @var string $measurement
     */
    private $measurement;

    /**
     * @var array $range
     */
    private $range;
    
    public function from(array $from): QueryBuilder
    {
        $this->from = $from;
        $this->addToQuery(
            self::FLUX_PART_FROM,
            new From($this->from)
        );
        return $this;
    }

    public function fromBucket(string $bucket): QueryBuilder {
        $this->from(['bucket' => $bucket]);
        return $this;
    }

    public function fromMeasurement(string $measurement): QueryBuilder
    {
        $this->measurement = $measurement;
        $this->addToQueryArray(
            self::FLUX_PART_FILTERS,
            new Filter(KeyValue::set('_measurement', $measurement))
        );
        return $this;
    }

    public function addRange(array $range): QueryBuilder
    {
        $this->range = $range;
        $this->addToQuery(
            self::FLUX_PART_RANGE,
            new Range($range)
        );
        return $this;
    }

    public function addRangeStart(string $rangeStart): QueryBuilder
    {
        $this->addRange(['start' => $rangeStart]);
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

        if(isset($this->fluxQueryParts[self::FLUX_PART_FROM])) {
            $query .= $this->fluxQueryParts[self::FLUX_PART_FROM];
        }

        if(isset($this->fluxQueryParts[self::FLUX_PART_RANGE])) {
            $query .= $this->fluxQueryParts[self::FLUX_PART_RANGE];
        }

        if(isset($this->fluxQueryParts[self::FLUX_PART_FILTERS])) {
            foreach($this->fluxQueryParts[self::FLUX_PART_FILTERS] as $filter) {
                $query .= $filter;
            }
        }

        return $query;

        //TODO: build the query dynamically here
        return 'from(bucket: "test_bucket") |> ';
    }

    protected function checkRequired()
    {
        if(!$this->from)
        {
            throw new Exception('You need to define the from part of the query!');
        }

        if(!$this->measurement)
        {
            throw new Exception('You need to define the measurement of the query!');
        }

        if(!$this->range)
        {
            throw new Exception('You need to define the range part of the query!');
        }
    }

}