<?php

namespace Arendsen\FluxQueryBuilder;

class QueryBuilder {

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
        return $this;
    }

    public function fromBucket(string $bucket): QueryBuilder {
        $this->from = ['bucket' => $bucket];
        return $this;
    }

    public function fromMeasurement(string $measurement): QueryBuilder
    {
        $this->measurement = $measurement;
        return $this;
    }

    public function addRange(array $range): QueryBuilder
    {
        $this->range = $range;
        return $this;
    }

    public function addRangeStart(string $rangeStart): QueryBuilder
    {
        $this->range = ['start' => $rangeStart];
        return $this;
    }

    public function build(): string
    {
        //TODO: build the query dynamically here
        return 'from(bucket: "test_bucket", host: "host", org: "example-org", token: "token") |> ';
    }

}