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

    public function testDateTimeToString()
    {
        $dateTime = new DateTime('2022-08-12 17:31:00');

        $expected = 'time(v: 2022-08-12T17:31:00Z)';

        $this->assertEquals($expected, Formatters::dateTimeToString($dateTime));
    }

}