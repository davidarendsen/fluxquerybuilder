<?php
declare(strict_types=1);

use Arendsen\FluxQueryBuilder\Expression\KeyValue;
use PHPUnit\Framework\TestCase;

final class KeyValueExpressionTest extends TestCase {

    public function testSimpleKeyvalue()
    {
        $keyvalue = KeyValue::setEqualTo('_measurement', 'test_measurement')
            ->andEqualTo('_field', 'user')
            ->or('count', '>=', '1')
            ->and('user', KeyValue::EQUAL_TO, 'my_username')
            ->orNotEqualTo('test', 'world');

        $query = 'r._measurement == "test_measurement" and r._field == "user" or ' . 
            'r.count >= "1" and r.user == "my_username" or r.test != "world"';

        $this->assertEquals($keyvalue->__toString(), $query);
    }

    public function testInvalidOperator()
    {
        $this->expectException(Exception::class);

        KeyValue::set('_measurement', '9dkda9e', 'test_measurement')
            ->andEqualTo('_field', 'user')
            ->or('_field', '==', 'field2')
            ->andEqualTo('user', 'my_username');
    }

}