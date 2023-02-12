<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\Unique;
use PHPUnit\Framework\TestCase;

final class UniqueunctionTest extends TestCase
{
    public function testSimpleUnique()
    {
        $expression = new Unique();

        $query = '|> unique() ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testUniqueWithColumn()
    {
        $expression = new Unique('something');

        $query = '|> unique(column: "something") ';

        $this->assertEquals($query, $expression->__toString());
    }
}
