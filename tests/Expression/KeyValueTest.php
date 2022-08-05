<?php
declare(strict_types=1);

use Arendsen\FluxQueryBuilder\Expression\KeyValue;
use PHPUnit\Framework\TestCase;

final class KeyValueExpressionTest extends TestCase {

    public function testSimpleKeyvalue()
    {
        $keyvalue = KeyValue::set('_measurement', 'test_measurement')
            ->and('_field', 'user')
            ->or('_field', 'field2')
            ->and('user', 'my_username');

        $query = 'r._measurement == "test_measurement" and r._field == "user" or ' . 
            'r._field == "field2" and r.user == "my_username"';

        $this->assertEquals($keyvalue->__toString(), $query);
    }

}