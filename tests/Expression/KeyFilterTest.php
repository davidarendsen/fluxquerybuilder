<?php

declare(strict_types=1);

namespace Tests\Expression;

use Exception;
use Arendsen\FluxQueryBuilder\Expression\KeyFilter;
use PHPUnit\Framework\TestCase;

final class KeyFilterExpressionTest extends TestCase
{
    public function testSimpleKeyvalue()
    {
        $keyFilter = KeyFilter::setEqualTo('_measurement', 'test_measurement')
            ->andEqualTo('_field', 'user')
            ->or('count', '>=', '1')
            ->and('user', KeyFilter::EQUAL_TO, 'my_username')
            ->orNotEqualTo('test', 'world');

        $query = 'r._measurement == "test_measurement" and r._field == "user" or ' .
            'r.count >= "1" and r.user == "my_username" or r.test != "world"';

        $this->assertEquals($keyFilter->__toString(), $query);
    }

    public function testInvalidOperator()
    {
        $this->expectException(Exception::class);

        KeyFilter::set('_measurement', '9dkda9e', 'test_measurement')
            ->andEqualTo('_field', 'user')
            ->or('_field', '==', 'field2')
            ->andEqualTo('user', 'my_username');
    }
}
