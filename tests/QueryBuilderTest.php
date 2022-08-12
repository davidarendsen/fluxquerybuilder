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
                new DateTime('2022-08-12 23:05:00'),
                null,
                'from(bucket: "example_bucket") |> range(start: time(v: 2022-08-12T23:05:00Z)) ' . 
                    '|> filter(fn: (r) => r._measurement == "test_measurement") '
            ],
            'query with filter' => [
                [
                    'bucket' => 'example_bucket',
                ],
                'test_measurement',
                new DateTime('2022-08-12 20:05:00'),
                KeyValue::setEqualTo('user', 'username'),
                'from(bucket: "example_bucket") |> range(start: time(v: 2022-08-12T20:05:00Z)) ' . 
                    '|> filter(fn: (r) => r._measurement == "test_measurement") ' . 
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
            $queryBuilder->addRangeStart($range['start']);
        }

        $queryBuilder->build();
    }

    public function throwsExceptionWithoutRequiredDataProvider(): array
    {
        return [
            'without from data' => [
                null, 'test_measurement', ['start' => new DateTime('2022-08-12 20:05:00')],
            ],
            'without measurement data' => [
                ['from' => 'test_bucket'], null, ['start' => new DateTime('2022-08-12 20:05:00')],
            ],
            'without range data' => [
                ['from' => 'test_bucket'], 'test_measurement', null,
            ],
        ];
    }

    public function testComplexQuery()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->fromBucket('test_bucket')
            ->fromMeasurement('test_measurement')
		    ->addRangeStart(new DateTime('2022-08-12 17:31:00'))
            ->addFilter(KeyValue::setEqualTo('_field', 'username'))
            ->addMap('r with name: r.user')
            ->addGroup(['_field', 'ip'])
            ->addReduce(['count' => 'accumulator.count + 1'], ['count' => 0])
            ->addFilter(KeyValue::setGreaterOrEqualTo('count', 1)->andGreaterOrEqualTo('count2', 2));

        $expectedQuery = 'from(bucket: "test_bucket") |> range(start: time(v: 2022-08-12T17:31:00Z)) ' . 
            '|> reduce(fn: (r, accumulator) => ({count: accumulator.count + 1}), identity: {count: 0}) ' . 
            '|> filter(fn: (r) => r._measurement == "test_measurement") |> filter(fn: (r) => r._field == "username") ' . 
            '|> filter(fn: (r) => r.count >= 1 and r.count2 >= 2) |> map(fn: (r) => ({ r with name: r.user })) ' . 
            '|> group(columns: ["_field", "ip"], mode: "by") ';

        $this->assertEquals($expectedQuery, $queryBuilder->build());
    }

}