<?php

declare(strict_types=1);

namespace Tests;

use DateTime;
use Exception;
use Arendsen\FluxQueryBuilder\Expression\KeyFilter;
use Arendsen\FluxQueryBuilder\Expression\KeyValue;
use PHPUnit\Framework\TestCase;
use Arendsen\FluxQueryBuilder\QueryBuilder;
use Arendsen\FluxQueryBuilder\Type\MathType;

final class QueryBuilderTest extends TestCase
{
    /**
     * @dataProvider simpleQueryProvider
     */
    public function testSimpleQuery($bucket, $measurement, $range, $keyFilter, $expectedQuery)
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->from($bucket)
            ->addRangeStart($range)
            ->fromMeasurement($measurement);

        if ($keyFilter) {
            $queryBuilder->addKeyFilter($keyFilter);
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
                KeyFilter::setEqualTo('user', 'username'),
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

        if ($from) {
            $queryBuilder->from($from);
        }
        if ($range) {
            $queryBuilder->addRangeStart($range['start']);
        }
        if ($measurement) {
            $queryBuilder->fromMeasurement($measurement);
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

    public function testThrowsExceptionWhenIncorrectOrder()
    {
        $this->expectException(Exception::class);

        $queryBuilder = new QueryBuilder();
        $queryBuilder->from(['bucket' => 'test_bucket'])
            ->fromMeasurement('test_measurement')
            ->addRangeStart(new DateTime('2022-08-12 20:05:00'));

        $queryBuilder->build();
    }

    public function testComplexQuery()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->fromBucket('test_bucket')
            ->addRangeStart(new DateTime('2022-08-12 17:31:00'))
            ->addReduce(['count' => new MathType('accumulator.count + 1')], ['count' => 0])
            ->fromMeasurement('test_measurement')
            ->addFieldFilter(['username', 'ip'])
            ->addKeyFilter(KeyFilter::setGreaterOrEqualTo('count', 1)->andGreaterOrEqualTo('count2', 2))
            ->addMap('r with name: r.user')
            ->addGroup(['_field', 'ip'])
            ->addLimit(1);

        $expectedQuery = 'from(bucket: "test_bucket") |> range(start: time(v: 2022-08-12T17:31:00Z)) ' .
            '|> reduce(fn: (r, accumulator) => ({count: accumulator.count + 1}), identity: {count: 0}) ' .
            '|> filter(fn: (r) => r._measurement == "test_measurement") |> filter(fn: (r) => ' .
            'r._field == "username" or r._field == "ip") |> filter(fn: (r) => r.count >= 1 and r.count2 >= 2) ' .
            '|> map(fn: (r) => ({ r with name: r.user })) |> group(columns: ["_field", "ip"], mode: "by") |> limit(n: 1, offset: 0) ';

        $this->assertEquals($expectedQuery, $queryBuilder->build());
    }

    public function testQueryWithWindow()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->fromBucket('test_bucket')
            ->addRangeStart(new DateTime('2022-08-12 17:31:00'))
            ->addReduce(['count' => new MathType('accumulator.count + 1')], ['count' => 0])
            ->addWindow('20s')
            ->addMean()
            ->addDuplicate('tag', 'tag_dup')
            ->fromMeasurement('test_measurement')
            ->addFilter(KeyValue::setGreaterOrEqualTo('count', 2)->andGreaterOrEqualTo('count2', 3))
            ->addKeyFilter(KeyFilter::setGreaterOrEqualTo('count', 1)->andGreaterOrEqualTo('count2', 2))
            ->addUnWindow();

        $expectedQuery = 'from(bucket: "test_bucket") |> range(start: time(v: 2022-08-12T17:31:00Z)) ' .
            '|> reduce(fn: (r, accumulator) => ({count: accumulator.count + 1}), identity: {count: 0}) ' .
            '|> window(every: 20s) |> mean() |> duplicate(column: "tag", as: "tag_dup") ' .
            '|> filter(fn: (r) => r._measurement == "test_measurement") ' .
            '|> filter(fn: (r) => r.count >= 2 and r.count2 >= 3) ' .
            '|> filter(fn: (r) => r.count >= 1 and r.count2 >= 2) |> window(every: inf) ';

        $this->assertEquals($expectedQuery, $queryBuilder->build());
    }

    public function testQueryWithAggregateWindow()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->fromBucket('test_bucket')
            ->addRangeStart(new DateTime('2022-08-12 17:31:00'))
            ->addReduce(['count' => new MathType('accumulator.count + 1')], ['count' => 0])
            ->fromMeasurement('test_measurement')
            ->addAggregateWindow('20s', 'mean', ['timeDst' => '_time']);

        $expectedQuery = 'from(bucket: "test_bucket") |> range(start: time(v: 2022-08-12T17:31:00Z)) ' .
            '|> reduce(fn: (r, accumulator) => ({count: accumulator.count + 1}), identity: {count: 0}) ' .
            '|> filter(fn: (r) => r._measurement == "test_measurement") ' .
            '|> aggregateWindow(every: 20s, fn: mean, timeDst: "_time") ';

        $this->assertEquals($expectedQuery, $queryBuilder->build());
    }

    public function testRawQuery()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->fromBucket('test_bucket')
            ->addRangeStart(new DateTime('2022-08-12 17:31:00'))
            ->addReduce(['count' => new MathType('accumulator.count + 1')], ['count' => 0])
            ->fromMeasurement('test_measurement')
            ->addRawFunction('|> aggregateWindow(every: 20s, fn: mean, timeDst: "_time")')
            ->addLimit(50, 100);

        $expectedQuery = 'from(bucket: "test_bucket") |> range(start: time(v: 2022-08-12T17:31:00Z)) ' .
            '|> reduce(fn: (r, accumulator) => ({count: accumulator.count + 1}), identity: {count: 0}) ' .
            '|> filter(fn: (r) => r._measurement == "test_measurement") ' .
            '|> aggregateWindow(every: 20s, fn: mean, timeDst: "_time") |> limit(n: 50, offset: 100) ';

        $this->assertEquals($expectedQuery, $queryBuilder->build());
    }
}
