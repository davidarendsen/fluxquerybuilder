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

    const PARTS = [
        self::FLUX_PART_FROM,
        self::FLUX_PART_RANGE,
        self::FLUX_PART_FILTERS
    ];

    const REQUIRED_INPUT_FROM = 'from';
    const REQUIRED_INPUT_MEASUREMENT = 'measurement';
    const REQUIRED_INPUT_RANGE = 'range';

    const REQUIRED_INPUT = [
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
            new Filter(KeyValue::set('_measurement', $measurement))
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

    public function addRange(array $range): QueryBuilder
    {
        $this->addRequiredData(self::REQUIRED_INPUT_RANGE, $range);
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

        foreach(self::PARTS as $part)
        {
            if(isset($this->fluxQueryParts[$part]))
            {
                if(is_array($this->fluxQueryParts[$part]))
                {
                    foreach($this->fluxQueryParts[$part] as $filter) {
                        $query .= $filter;
                    }
                }
                else
                {
                    $query .= $this->fluxQueryParts[$part];
                }
            }
        }

        return $query;
    }

    protected function addRequiredData(string $key, $value) {
        $this->requiredData[$key] = $value;
    }

    protected function checkRequired()
    {
        foreach(self::REQUIRED_INPUT as $input) {
            if(!isset($this->requiredData[$input]))
            {
                throw new Exception('You need to define the "' . $input . '" part of the query!');
            }
        }
    }

}