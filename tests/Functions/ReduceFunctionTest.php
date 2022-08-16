<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\Reduce;
use Arendsen\FluxQueryBuilder\Type\Math;
use PHPUnit\Framework\TestCase;

final class ReduceFunctionTest extends TestCase
{
    public function testSimpleReduce()
    {
        $expression = new Reduce(['sum' => new Math('r._value + accumulator.sum')], ['sum' => 0]);

        $query = '|> reduce(fn: (r, accumulator) => ({sum: r._value + accumulator.sum}), identity: {sum: 0}) ';

        $this->assertEquals($query, $expression->__toString());
    }
}
