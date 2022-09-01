<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\Duplicate;
use PHPUnit\Framework\TestCase;

final class DuplicateFunctionTest extends TestCase
{
    public function testSimpleDuplicate()
    {
        $expression = new Duplicate('tag', 'tag_dup');

        $query = '|> duplicate(column: "tag", as: "tag_dup") ';

        $this->assertEquals($query, $expression->__toString());
    }
}
