<?php

declare(strict_types=1);

namespace Tests\Type;

use DateTime;
use Arendsen\FluxQueryBuilder\Type;
use Arendsen\FluxQueryBuilder\Type\CustomType;
use Arendsen\FluxQueryBuilder\Type\DurationType;
use Arendsen\FluxQueryBuilder\Type\FnType;
use Arendsen\FluxQueryBuilder\Type\MathType;
use Arendsen\FluxQueryBuilder\Type\RecordType;
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
            'RecordType' => [
                new RecordType(['foo' => 'bar', 'nested' => ['hello' => 'world']]),
                '{foo: "bar", nested: {hello: "world"}}'
            ],
            'DurationType' => [
                new DurationType('5h'),
                '5h',
            ],
            'MathType' => [
                new MathType('r.count + 1'),
                'r.count + 1'
            ],
            'CustomType' => [
                new CustomType('this can be anything'),
                'this can be anything'
            ],
            'FnType with only content' => [
                new FnType('(r) => ({ r with _value: r._value * r._value })'),
                '(r) => ({ r with _value: r._value * r._value })'
            ],
            'FnType with params and content' => [
                new FnType(['r', 'a'], '({ r with _value: r._value * r._value })'),
                '(r, a) => ({ r with _value: r._value * r._value })'
            ],
        ];
    }
}
