<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\Min;
use PHPUnit\Framework\TestCase;

final class MinFunctionTest extends TestCase
{
    public function testSimpleMin()
    {
        $expression = new Min();

        $query = '|> min() ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testMinWithColumn()
    {
        $expression = new Min('something');

        $query = '|> min(column: "something") ';

        $this->assertEquals($query, $expression->__toString());
    }
}
