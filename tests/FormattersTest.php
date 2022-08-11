<?php
declare(strict_types=1);

use Arendsen\FluxQueryBuilder\Formatters;
use PHPUnit\Framework\TestCase;

final class FormattersTest extends TestCase {

    public function testAssociativeArrayNested()
    {
        $array = [
            'columns' => ['foo', 'bar'],
            'mode' => 'by'
        ];

        $expected = 'columns: ["foo", "bar"], mode: "by"';

        $this->assertEquals($expected, Formatters::toFluxArrayString($array));
    }

}