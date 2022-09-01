<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\Mean;
use PHPUnit\Framework\TestCase;

final class MeanFunctionTest extends TestCase
{
    public function testSimpleMean()
    {
        $expression = new Mean();

        $query = '|> mean() ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testWithParameterColumn()
    {
        $expression = new Mean('test');

        $query = '|> mean(column: "test") ';

        $this->assertEquals($query, $expression->__toString());
    }
}
