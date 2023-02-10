<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\Last;
use PHPUnit\Framework\TestCase;

final class LastFunctionTest extends TestCase
{
    public function testSimpleLast()
    {
        $expression = new Last();

        $query = '|> last(column: "_value") ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testLastWithValue()
    {
        $expression = new Last('something');

        $query = '|> last(column: "something") ';

        $this->assertEquals($query, $expression->__toString());
    }
}
