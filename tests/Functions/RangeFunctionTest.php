<?php

declare(strict_types=1);

namespace Tests\Functions;

use DateTime;
use Arendsen\FluxQueryBuilder\Functions\Range;
use PHPUnit\Framework\TestCase;

final class RangeFunctionTest extends TestCase
{
    public function testOnlyStartOption()
    {
        $expression = new Range(
            new DateTime('2022-08-12 18:00:00')
        );

        $query = '|> range(start: time(v: 2022-08-12T18:00:00Z)) ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testWithStopOption()
    {
        $expression = new Range(
            new DateTime('2022-08-12 18:00:00'),
            new DateTime('2022-08-12 20:00:00')
        );

        $query = '|> range(start: time(v: 2022-08-12T18:00:00Z), stop: time(v: 2022-08-12T20:00:00Z)) ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testRangeInBetween()
    {
        $expression = new Range(
            new DateTime('2022-08-12 17:31:00'),
            new DateTime('2022-08-12 18:31:00'),
        );

        $expected = '|> range(start: time(v: 2022-08-12T17:31:00Z), stop: time(v: 2022-08-12T18:31:00Z)) ';

        $this->assertEquals($expected, $expression->__toString());
    }
}
