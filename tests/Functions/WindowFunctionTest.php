<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\Window;
use PHPUnit\Framework\TestCase;

final class WindowFunctionTest extends TestCase
{
    public function testSimpleWindow()
    {
        $expression = new Window('20s');

        $query = '|> window(every: 20s) ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testAllParameters()
    {
        $expression = new Window('20s', [
            'period' => 'every', 
            'offset' => '0s',
            'location' => 'location', 
            'timeColumn' => '_time', 
            'startColumn' => '_start', 
            'stopColumn' => '_stop', 
            'createEmpty' => true
        ]);

        $query = '|> window(every: 20s, period: every, offset: 0s, location: "location", ' .
            'timeColumn: "_time", startColumn: "_start", stopColumn: "_stop", createEmpty: true) ';

        $this->assertEquals($query, $expression->__toString());
    }
}
