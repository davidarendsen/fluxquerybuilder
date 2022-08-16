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
            'Integer' => [
                12345,
                '12345'
            ],
            'Boolean True' => [
                true,
                'true'
            ],
            'Boolean False' => [
                false,
                'false'
            ],
            'Array' => [
                ['hello', 'world'],
                '"hello", "world"'
            ],
            'Dictionary' => [
                ['hello' => 'world', 'foo' => 'bar'],
                'hello: "world", foo: "bar"'
            ],
            'Array Multidimensional' => [
                ['hello' => ['test', 'foo']],
                'hello: ["test", "foo"]'
            ],
            'Array Multidimensional 2' => [
                ['hello' => ['test' => 'bar', 'foo' => 'hi']],
                'hello: [test: "bar", foo: "hi"]'
            ],
        ];
    }
}
