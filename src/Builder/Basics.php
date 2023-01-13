<?php

namespace Arendsen\FluxQueryBuilder\Builder;

use DateTime;
use Arendsen\FluxQueryBuilder\QueryBuilder;
use Arendsen\FluxQueryBuilder\Builder\QueryBuilderInterface;
use Arendsen\FluxQueryBuilder\Builder\FluxPart;
use Arendsen\FluxQueryBuilder\Expression\KeyValue;
use Arendsen\FluxQueryBuilder\Expression\KeyFilter;
use Arendsen\FluxQueryBuilder\Functions\Filter;
use Arendsen\FluxQueryBuilder\Functions\From;
use Arendsen\FluxQueryBuilder\Functions\Range;
use Arendsen\FluxQueryBuilder\Functions\RawFunction;

trait Basics
{
    public function from(array $from): QueryBuilderInterface
    {
        $this->addRequiredData(QueryBuilder::REQUIRED_INPUT_FROM, $from);
        $this->addToQuery(
            FluxPart::FROM,
            new From($from)
        );
        return $this;
    }

    public function fromBucket(string $bucket): QueryBuilderInterface
    {
        $this->from(['bucket' => $bucket]);
        return $this;
    }

    public function fromMeasurement(string $measurement): QueryBuilderInterface
    {
        $this->addRequiredData(QueryBuilder::REQUIRED_INPUT_MEASUREMENT, $measurement);
        $this->addKeyFilter(KeyFilter::setEqualTo('_measurement', $measurement));
        return $this;
    }

    /**
     * @deprecated
     *
     * @param KeyValue $keyValue
     * @return QueryBuilder
     */
    public function addFilter(KeyValue $keyValue): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::FILTERS,
            new Filter($keyValue)
        );
        return $this;
    }

    public function addKeyFilter(KeyFilter $keyFilter): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::FILTERS,
            new Filter($keyFilter)
        );
        return $this;
    }

    public function addFieldFilter(array $fields): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::FILTERS,
            new Filter($fields)
        );
        return $this;
    }

    public function addRange(DateTime $start, ?DateTime $stop = null): QueryBuilderInterface
    {
        $this->addRequiredData(QueryBuilder::REQUIRED_INPUT_RANGE, [$start, $stop]);
        $this->addToQuery(
            FluxPart::RANGE,
            new Range($start, $stop)
        );
        return $this;
    }

    public function addRangeStart(DateTime $start): QueryBuilderInterface
    {
        $this->addRange($start);
        return $this;
    }

    public function addRangeInBetween(DateTime $start, DateTime $stop): QueryBuilderInterface
    {
        $this->addRange($start, $stop);
        return $this;
    }

    public function addRawFunction(string $input): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::RAWFUNCTION,
            new RawFunction($input)
        );
        return $this;
    }
}
