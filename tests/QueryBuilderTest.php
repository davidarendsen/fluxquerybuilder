<?php
declare(strict_types=1);

use Arendsen\FluxQueryBuilder\Expression\KeyValue;
use PHPUnit\Framework\TestCase;
use Arendsen\FluxQueryBuilder\QueryBuilder;

final class QueryBuilderTest extends TestCase {

    /**
     * @dataProvider simpleQueryProvider
     */
    public function testSimpleQuery($bucket, $measurement, $range, $keyValue, $expectedQuery)
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->from($bucket)
            ->fromMeasurement($measurement)
			->addRangeStart($range);

        if($keyValue)
        {
            $queryBuilder->addFilter($keyValue);
        }

        $this->assertEquals($expectedQuery, $queryBuilder->build());
    }

    public function simpleQueryProvider(): array
    {
        return [
            'basic query' => [
                [
                    'bucket' => 'example_bucket',
                ],
                'test_measurement',
                '-360h',
                null,
                'from(bucket: "example_bucket") |> range(start: "-360h") |> filter(fn: (r) => r._measurement == "test_measurement") '
            ],
            'query with filter' => [
                [
                    'bucket' => 'example_bucket',
                ],
                'test_measurement',
                '-360h',
                KeyValue::setEqualTo('user', 'username'),
                'from(bucket: "example_bucket") |> range(start: "-360h") |> filter(fn: (r) => r._measurement == "test_measurement") ' . 
                    '|> filter(fn: (r) => r.user == "username") '
            ],
        ];
    }

    /**
     * @dataProvider throwsExceptionWithoutRequiredDataProvider
     */
    public function testThrowsExceptionWithoutRequiredData($from, $measurement, $range)
    {
        $this->expectException(Exception::class);

        $queryBuilder = new QueryBuilder();

        if($from) {
            $queryBuilder->from($from);
        }
        if($measurement) {
            $queryBuilder->fromMeasurement($measurement);
        }
        if($range) {
            $queryBuilder->addRange($range);
        }

        $queryBuilder->build();
    }

    public function throwsExceptionWithoutRequiredDataProvider(): array
    {
        return [
            'without from data' => [
                null, 'test_measurement', ['start' => '-360h'],
            ],
            'without measurement data' => [
                ['from' => 'test_bucket'], null, ['start' => '-360h'],
            ],
            'without range data' => [
                ['from' => 'test_bucket'], 'test_measurement', null,
            ],
        ];
    }

}