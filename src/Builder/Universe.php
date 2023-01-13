<?php

namespace Arendsen\FluxQueryBuilder\Builder;

use Arendsen\FluxQueryBuilder\Builder\QueryBuilderInterface;
use Arendsen\FluxQueryBuilder\Builder\FluxPart;
use Arendsen\FluxQueryBuilder\Functions\AggregateWindow;
use Arendsen\FluxQueryBuilder\Functions\Duplicate;
use Arendsen\FluxQueryBuilder\Functions\Reduce;
use Arendsen\FluxQueryBuilder\Functions\Sort;
use Arendsen\FluxQueryBuilder\Functions\Map;
use Arendsen\FluxQueryBuilder\Functions\Group;
use Arendsen\FluxQueryBuilder\Functions\Limit;
use Arendsen\FluxQueryBuilder\Functions\Mean;
use Arendsen\FluxQueryBuilder\Functions\Window;

trait Universe
{
    public function addReduce(array $settings, array $identity): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::REDUCE,
            new Reduce($settings, $identity)
        );
        return $this;
    }

    public function addSort(array $columns, $desc): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::SORT,
            new Sort($columns, $desc)
        );
        return $this;
    }

    public function addMap($query): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::MAP,
            new Map($query)
        );
        return $this;
    }

    public function addGroup(array $columns, $mode = 'by'): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::GROUP,
            new Group($columns, $mode)
        );
        return $this;
    }

    public function addLimit(int $limit, int $offset = 0): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::LIMIT,
            new Limit($limit, $offset)
        );
        return $this;
    }

    public function addWindow($every, array $options = []): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::WINDOW,
            new Window($every, $options)
        );
        return $this;
    }

    public function addDuplicate(string $column, string $as): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::DUPLICATE,
            new Duplicate($column, $as)
        );
        return $this;
    }

    public function addMean(?string $column = ''): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::MEAN,
            new Mean($column)
        );
        return $this;
    }

    public function addUnWindow(): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::UNWINDOW,
            new Window('inf')
        );
        return $this;
    }

    public function addAggregateWindow($every, $fn, array $options = []): QueryBuilderInterface
    {
        $this->addToQuery(
            FluxPart::AGGREGATEWINDOW,
            new AggregateWindow($every, $fn, $options)
        );
        return $this;
    }
}
