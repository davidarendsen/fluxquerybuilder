<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\Max;
use PHPUnit\Framework\TestCase;

final class MaxFunctionTest extends TestCase
{
    public function testSimpleMax()
    {
        $expression = new Max();

        $query = '|> max() ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testMaxWithColumn()
    {
        $expression = new Max('something');

        $query = '|> max(column: "something") ';

        $this->assertEquals($query, $expression->__toString());
    }
}
