<?php
declare(strict_types=1);

use Arendsen\FluxQueryBuilder\Functions\Map;
use PHPUnit\Framework\TestCase;

final class MapFunctionTest extends TestCase {

    public function testSimpleMap()
    {
        $expression = new Map('r with name: r.user');

        $query = '|> map(fn: (r) => ({ r with name: r.user })) ';

        $this->assertEquals($query, $expression->__toString());
    }

}