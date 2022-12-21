<?php

namespace Arendsen\FluxQueryBuilder;

use Arendsen\FluxQueryBuilder\Builder\AbstractQueryBuilder;
use Arendsen\FluxQueryBuilder\Builder\FluxPart;
use Arendsen\FluxQueryBuilder\Functions\AggregateWindow;
use Arendsen\FluxQueryBuilder\Functions\Duplicate;
use Arendsen\FluxQueryBuilder\Functions\Reduce;
use Arendsen\FluxQueryBuilder\Functions\Sort;
use Arendsen\FluxQueryBuilder\Functions\Map;
use Arendsen\FluxQueryBuilder\Functions\Group;
use Arendsen\FluxQueryBuilder\Functions\Limit;
use Arendsen\FluxQueryBuilder\Functions\Mean;
use Arendsen\FluxQueryBuilder\Functions\RawFunction;
use Arendsen\FluxQueryBuilder\Functions\Window;

class QueryBuilder extends AbstractQueryBuilder
{
    public function addReduce(array $settings, array $identity): QueryBuilder
    {
        $this->addToQuery(
            FluxPart::REDUCE,
            new Reduce($settings, $identity)
        );
        return $this;
    }

    public function addSort(array $columns, $desc): QueryBuilder
    {
        $this->addToQuery(
            FluxPart::SORT,
            new Sort($columns, $desc)
        );
        return $this;
    }

    public function addMap($query): QueryBuilder
    {
        $this->addToQuery(
            FluxPart::MAP,
            new Map($query)
        );
        return $this;
    }

    public function addGroup(array $columns, $mode = 'by'): QueryBuilder
    {
        $this->addToQuery(
            FluxPart::GROUP,
            new Group($columns, $mode)
        );
        return $this;
    }

    public function addLimit(int $limit, int $offset = 0): QueryBuilder
    {
        $this->addToQuery(
            FluxPart::LIMIT,
            new Limit($limit, $offset)
        );
        return $this;
    }

    public function addWindow($every, array $options = []): QueryBuilder
    {
        $this->addToQuery(
            FluxPart::WINDOW,
            new Window($every, $options)
        );
        return $this;
    }

    public function addDuplicate(string $column, string $as): QueryBuilder
    {
        $this->addToQuery(
            FluxPart::DUPLICATE,
            new Duplicate($column, $as)
        );
        return $this;
    }

    public function addMean(?string $column = ''): QueryBuilder
    {
        $this->addToQuery(
            FluxPart::MEAN,
            new Mean($column)
        );
        return $this;
    }

    public function addUnWindow(): QueryBuilder
    {
        $this->addToQuery(
            FluxPart::UNWINDOW,
            new Window('inf')
        );
        return $this;
    }

    public function addAggregateWindow($every, $fn, array $options = []): QueryBuilder
    {
        $this->addToQuery(
            FluxPart::AGGREGATEWINDOW,
            new AggregateWindow($every, $fn, $options)
        );
        return $this;
    }

    public function addRawFunction(string $input): QueryBuilder
    {
        $this->addToQuery(
            FluxPart::RAWFUNCTION,
            new RawFunction($input)
        );
        return $this;
    }
}
