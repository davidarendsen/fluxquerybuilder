<?php
declare(strict_types=1);

use Arendsen\FluxQueryBuilder\Function\Group;
use PHPUnit\Framework\TestCase;

final class GroupFunctionTest extends TestCase {

    public function testSimpleGroup()
    {
        $expression = new Group(['foo', 'bar'], 'by');

        $query = '|> group(columns: ["foo", "bar"], mode: "by") ';

        $this->assertEquals($query, $expression->__toString());
    }

}