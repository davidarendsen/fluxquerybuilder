<?php
declare(strict_types=1);

use Arendsen\FluxQueryBuilder\Functions\Sort;
use PHPUnit\Framework\TestCase;

final class SortFunctionTest extends TestCase {

    public function testSimpleSort()
    {
        $expression = new Sort(['foo', 'bar'], true);

        $query = '|> sort(columns: ["foo", "bar"], desc: true) ';

        $this->assertEquals($query, $expression->__toString());
    }

}