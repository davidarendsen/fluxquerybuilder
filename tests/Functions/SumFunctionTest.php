<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\Sum;
use PHPUnit\Framework\TestCase;

final class SumFunctionTest extends TestCase
{
    public function testSimpleSum()
    {
        $expression = new Sum('_value');

        $query = '|> sum(column: "_value") ';

        $this->assertEquals($query, $expression->__toString());
    }
}
