<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\Limit;
use PHPUnit\Framework\TestCase;

final class LimitFunctionTest extends TestCase
{
    public function testSimpleLimit()
    {
        $expression = new Limit(1);

        $query = '|> limit(n: 1, offset: 0) ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testLimitWithOffset()
    {
        $expression = new Limit(10, 2);

        $query = '|> limit(n: 10, offset: 2) ';

        $this->assertEquals($query, $expression->__toString());
    }
}
