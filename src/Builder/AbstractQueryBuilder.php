<?php

namespace Arendsen\FluxQueryBuilder\Builder;

use DateTime;
use Exception;
use Arendsen\FluxQueryBuilder\Builder\FluxPart;
use Arendsen\FluxQueryBuilder\Expression\KeyValue;
use Arendsen\FluxQueryBuilder\Expression\KeyFilter;
use Arendsen\FluxQueryBuilder\Functions\Filter;
use Arendsen\FluxQueryBuilder\Functions\From;
use Arendsen\FluxQueryBuilder\Functions\Range;

abstract class AbstractQueryBuilder
{
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

    public function from(array $from): AbstractQueryBuilder
    {
        $this->addRequiredData(self::REQUIRED_INPUT_FROM, $from);
        $this->addToQuery(
            FluxPart::FROM,
            new From($from)
        );
        return $this;
    }

    public function fromBucket(string $bucket): AbstractQueryBuilder
    {
        $this->from(['bucket' => $bucket]);
        return $this;
    }

    public function fromMeasurement(string $measurement): AbstractQueryBuilder
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
    public function addFilter(KeyValue $keyValue): AbstractQueryBuilder
    {
        $this->addToQuery(
            FluxPart::FILTERS,
            new Filter($keyValue)
        );
        return $this;
    }

    public function addKeyFilter(KeyFilter $keyFilter): AbstractQueryBuilder
    {
        $this->addToQuery(
            FluxPart::FILTERS,
            new Filter($keyFilter)
        );
        return $this;
    }

    public function addFieldFilter(array $fields): AbstractQueryBuilder
    {
        $this->addToQuery(
            FluxPart::FILTERS,
            new Filter($fields)
        );
        return $this;
    }

    public function addRange(DateTime $start, ?DateTime $stop = null): AbstractQueryBuilder
    {
        $this->addRequiredData(self::REQUIRED_INPUT_RANGE, [$start, $stop]);
        $this->addToQuery(
            FluxPart::RANGE,
            new Range($start, $stop)
        );
        return $this;
    }

    public function addRangeStart(DateTime $start): AbstractQueryBuilder
    {
        $this->addRange($start);
        return $this;
    }

    public function addRangeInBetween(DateTime $start, DateTime $stop)
    {
        $this->addRange($start, $stop);
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
