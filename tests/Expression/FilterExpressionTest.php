<?php
declare(strict_types=1);

use Arendsen\FluxQueryBuilder\Expression\Filter\AndExpression;
use Arendsen\FluxQueryBuilder\Expression\Filter\OrExpression;
use Arendsen\FluxQueryBuilder\Expression\Filter\Measurement;
use Arendsen\FluxQueryBuilder\Function\Filter;
use PHPUnit\Framework\TestCase;

final class FilterFunctionTest extends TestCase {

    public function testSimpleFilter()
    {
        $expression = new Filter([
            new Measurement('test_measurement'),
            new AndExpression('_field', 'user'),
            new OrExpression('_field', 'field2'),
            'and r.user == "my_username"',
        ]);

        $query = '|> filter(fn: (r) => r._measurement == "test_measurement" and r._field == "user" or ' . 
            'r._field == "field2" and r.user == "my_username") ';

        $this->assertEquals($expression->__toString(), $query);
    }

}