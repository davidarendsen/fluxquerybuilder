<?php

namespace Arendsen\FluxQueryBuilder\Builder;

use Arendsen\FluxQueryBuilder\Builder\QueryBuilderInterface;
use Arendsen\FluxQueryBuilder\Functions\AggregateWindow;
use Arendsen\FluxQueryBuilder\Functions\Duplicate;
use Arendsen\FluxQueryBuilder\Functions\Last;
use Arendsen\FluxQueryBuilder\Functions\Reduce;
use Arendsen\FluxQueryBuilder\Functions\Sort;
use Arendsen\FluxQueryBuilder\Functions\Map;
use Arendsen\FluxQueryBuilder\Functions\Group;
use Arendsen\FluxQueryBuilder\Functions\Limit;
use Arendsen\FluxQueryBuilder\Functions\Mean;
use Arendsen\FluxQueryBuilder\Functions\Window;
use Arendsen\FluxQueryBuilder\Functions\Sum;

trait Universe
{
    public function addReduce(array $settings, array $identity): QueryBuilderInterface
    {
        $this->addToQuery(
            new Reduce($settings, $identity)
        );
        return $this;
    }

    public function addSort(array $columns = ['_value'], bool $desc = false): QueryBuilderInterface
    {
        $this->addToQuery(
            new Sort($columns, $desc)
        );
        return $this;
    }

    public function addMap($query): QueryBuilderInterface
    {
        $this->addToQuery(
            new Map($query)
        );
        return $this;
    }

    public function addGroup(array $columns, $mode = 'by'): QueryBuilderInterface
    {
        $this->addToQuery(
            new Group($columns, $mode)
        );
        return $this;
    }

    public function addLimit(int $limit, int $offset = 0): QueryBuilderInterface
    {
        $this->addToQuery(
            new Limit($limit, $offset)
        );
        return $this;
    }

    public function addWindow($every, array $options = []): QueryBuilderInterface
    {
        $this->addToQuery(
            new Window($every, $options)
        );
        return $this;
    }

    public function addDuplicate(string $column, string $as): QueryBuilderInterface
    {
        $this->addToQuery(
            new Duplicate($column, $as)
        );
        return $this;
    }

    public function addMean(?string $column = ''): QueryBuilderInterface
    {
        $this->addToQuery(
            new Mean($column)
        );
        return $this;
    }

    public function addUnWindow(): QueryBuilderInterface
    {
        $this->addToQuery(
            new Window('inf')
        );
        return $this;
    }

    public function addAggregateWindow($every, $fn, array $options = []): QueryBuilderInterface
    {
        $this->addToQuery(
            new AggregateWindow($every, $fn, $options)
        );
        return $this;
    }

    public function addSum(string $column): QueryBuilderInterface
    {
        $this->addToQuery(
            new Sum($column)
        );
        return $this;
    }

    public function addLast(string $column = '_value'): QueryBuilderInterface
    {
        $this->addToQuery(
            new Last($column)
        );
        return $this;
    }
}
