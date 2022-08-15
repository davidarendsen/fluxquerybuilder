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

        $query = '|> limit(n:1) ';

        $this->assertEquals($query, $expression->__toString());
    }
}
