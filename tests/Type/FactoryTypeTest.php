<?php

declare(strict_types=1);

namespace Tests\Type;

use DateTime;
use Arendsen\FluxQueryBuilder\Type;
use PHPUnit\Framework\TestCase;

final class FactoryTypeTest extends TestCase
{
    /**
    * @dataProvider getFluxStringProvider
    */
    public function testGetFluxString($value, $expected)
    {
        $type = new Type($value);

        $this->assertEquals($expected, $type->__toString());
    }

    public function getFluxStringProvider()
    {
        return [
            'DateTime' => [
                new DateTime('2022-08-15 23:09:00'),
                'time(v: 2022-08-15T23:09:00Z)',
            ],
            'String' => [
                'value',
                '"value"',
            ],
        ];
    }
}
