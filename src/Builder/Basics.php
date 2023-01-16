<?php

namespace Arendsen\FluxQueryBuilder\Builder;

use DateTime;
use Arendsen\FluxQueryBuilder\QueryBuilder;
use Arendsen\FluxQueryBuilder\Builder\QueryBuilderInterface;
use Arendsen\FluxQueryBuilder\Expression\KeyValue;
use Arendsen\FluxQueryBuilder\Expression\KeyFilter;
use Arendsen\FluxQueryBuilder\Functions\Filter;
use Arendsen\FluxQueryBuilder\Functions\From;
use Arendsen\FluxQueryBuilder\Functions\Measurement;
use Arendsen\FluxQueryBuilder\Functions\Range;
use Arendsen\FluxQueryBuilder\Functions\RawFunction;

trait Basics
{
    public function from(array $from): QueryBuilderInterface
    {
        $this->setRequirements();

        $this->addToQuery(
            new From($from)
        );

        return $this;
    }

    public function fromBucket(string $bucket): QueryBuilderInterface
    {
        return $this->from(['bucket' => $bucket]);
    }

    public function fromMeasurement(string $measurement): QueryBuilderInterface
    {
        $this->setRequirements();

        $this->addToQuery(
            new Measurement($measurement)
        );
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
        $this->setRequirements();

        $this->addToQuery(
            new Filter($keyValue)
        );
        return $this;
    }

    public function addKeyFilter(KeyFilter $keyFilter): QueryBuilderInterface
    {
        $this->setRequirements();

        $this->addToQuery(
            new Filter($keyFilter)
        );
        return $this;
    }

    public function addFieldFilter(array $fields): QueryBuilderInterface
    {
        $this->setRequirements();

        $this->addToQuery(
            new Filter($fields)
        );
        return $this;
    }

    public function addRange(DateTime $start, ?DateTime $stop = null): QueryBuilderInterface
    {
        $this->setRequirements();

        $this->addToQuery(
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
            new RawFunction($input)
        );
        return $this;
    }

    private function setRequirements()
    {
        $this->requiredFluxQueryParts = [
            From::class,
            Range::class,
            Measurement::class,
        ];
    }
}
