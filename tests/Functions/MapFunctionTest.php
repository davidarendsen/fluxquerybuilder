<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\Map;
use Arendsen\FluxQueryBuilder\Expression\Map as MapExpression;
use Arendsen\FluxQueryBuilder\Expression\Selection as SelectionExpression;
use PHPUnit\Framework\TestCase;

final class MapFunctionTest extends TestCase
{
    public function testSimpleMap()
    {
        $expression = new Map('r with name: r.user');

        $query = '|> map(fn: (r) => ({ r with name: r.user })) ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testWithMapObject()
    {
        $expression = new Map(MapExpression::with('name', 'r.user'));

        $query = '|> map(fn: (r) => ({ r with name: r.user })) ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testRecordMapObject()
    {
        $expression = new Map(MapExpression::columns([
            'time' => 'r._time',
            'source' => 'r.tag',
            'alert' => SelectionExpression::if('r._value > 10')->then(true)->else(false)->__toString(),
            'test' => SelectionExpression::if('r._value > 10')->then('yes')->else('no')->__toString()
        ])->__toString());

        $query = '|> map(fn: (r) => ({ {time: r._time, source: r.tag, ' .
            'alert: if r._value > 10 then true else false, ' .
            'test: if r._value > 10 then "yes" else "no"} })) ';

        $this->assertEquals($query, $expression->__toString());
    }
}
