<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\Count;
use PHPUnit\Framework\TestCase;

final class CountFunctionTest extends TestCase
{
    public function testSimpleCount()
    {
        $expression = new Count();

        $query = '|> count() ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testCountWithColumn()
    {
        $expression = new Count('_value');

        $query = '|> count(column: "_value") ';

        $this->assertEquals($query, $expression->__toString());
    }
}
