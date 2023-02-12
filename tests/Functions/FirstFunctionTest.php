<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\First;
use PHPUnit\Framework\TestCase;

final class FirstFunctionTest extends TestCase
{
    public function testSimpleFirst()
    {
        $expression = new First();

        $query = '|> first() ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testFirstWithColumn()
    {
        $expression = new First('something');

        $query = '|> first(column: "something") ';

        $this->assertEquals($query, $expression->__toString());
    }
}
