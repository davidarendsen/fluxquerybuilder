<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\AggregateWindow;
use PHPUnit\Framework\TestCase;

final class AggregateWindowFunctionTest extends TestCase
{
    public function testSimpleWindow()
    {
        $expression = new AggregateWindow('20s', null, null, 'mean');

        $query = '|> aggregateWindow(every: 20s, fn: mean) ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testAllParameters()
    {
        $expression = new AggregateWindow('20s', 'every', '0s', 'mean', 'location', '_value', '_stop', '_time', false);

        $query = '|> aggregateWindow(every: 20s, period: every, offset: 0s, fn: mean, location: "location", ' .
            'column: "_value", timeSrc: "_stop", timeDst: "_time", createEmpty: false) ';

        $this->assertEquals($query, $expression->__toString());
    }
}
