<?php

declare(strict_types=1);

namespace Tests;

use Closure;
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
     * @dataProvider newTestsProvider
     */
    public function testBasicQuery(string $methodName, array $params = [], string $expected = '')
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->fromBucket('test_bucket')
            ->addRangeStart(new DateTime('2022-08-12 17:31:00'))
            ->fromMeasurement('test_measurement');

        call_user_func_array([$queryBuilder, $methodName], $params);

        $expectedQuery = 'from(bucket: "test_bucket") |> range(start: time(v: 2022-08-12T17:31:00Z)) ' .
            '|> filter(fn: (r) => r._measurement == "test_measurement") ' . $expected;

        $this->assertEquals($expectedQuery, $queryBuilder->build());
    }

    public function newTestsProvider(): array
    {
        return [
            'addAggregateWindow' => [
                'addAggregateWindow',
                ['20s', 'mean', ['timeDst' => '_time']],
                '|> aggregateWindow(every: 20s, fn: mean, timeDst: "_time") '
            ],
            'addCount' => [
                'addCount',
                ['_value'],
                '|> count(column: "_value") '
            ],
            'addDuplicate' => [
                'addDuplicate',
                ['old_name', 'new_name'],
                '|> duplicate(column: "old_name", as: "new_name") '
            ],
            'addFilter' => [
                'addFilter',
                [KeyValue::setGreaterOrEqualTo('count', 2)->andGreaterOrEqualTo('count2', 3)],
                '|> filter(fn: (r) => r.count >= 2 and r.count2 >= 3) '
            ],
            'addKeyFilter' => [
                'addKeyFilter',
                [KeyFilter::setEqualTo('user', 'username')],
                '|> filter(fn: (r) => r.user == "username") '
            ],
            'addFieldFilter' => [
                'addFieldFilter',
                [['email', 'username']],
                '|> filter(fn: (r) => r._field == "email" or r._field == "username") '
            ],
            'addFirst' => [
                'addFirst',
                ['something'],
                '|> first(column: "something") '
            ],
            'addGroup' => [
                'addGroup',
                [['_field', 'ip']],
                '|> group(columns: ["_field", "ip"], mode: "by") '
            ],
            'addLast' => [
                'addLast',
                ['something'],
                '|> last(column: "something") '
            ],
            'addLimit' => [
                'addLimit',
                [20, 40],
                '|> limit(n: 20, offset: 40) '
            ],
            'addMap' => [
                'addMap',
                ['r with name: r.user'],
                '|> map(fn: (r) => ({ r with name: r.user })) '
            ],
            'addMax' => [
                'addMax',
                [],
                '|> max() '
            ],
            'addMean' => [
                'addMean',
                ['something'],
                '|> mean(column: "something") '
            ],
            'addMin' => [
                'addMin',
                ['something'],
                '|> min(column: "something") '
            ],
            'addRawFunction' => [
                'addRawFunction',
                ['|> aggregateWindow(every: 20s, fn: mean, timeDst: "_time")'],
                '|> aggregateWindow(every: 20s, fn: mean, timeDst: "_time") '
            ],
            'addReduce' => [
                'addReduce',
                [['count' => new MathType('accumulator.count + 1')], ['count' => 0]],
                '|> reduce(fn: (r, accumulator) => ({count: accumulator.count + 1}), identity: {count: 0}) '
            ],
            'addSort' => [
                'addSort',
                [['column1', 'column2'], true],
                '|> sort(columns: ["column1", "column2"], desc: true) '
            ],
            'addSum' => [
                'addSum',
                ['something'],
                '|> sum(column: "something") '
            ],
            'addUnwindow' => [
                'addUnwindow',
                [],
                '|> window(every: inf) '
            ],
            'addWindow' => [
                'addWindow',
                ['20s', ['timeColumn' => '_time']],
                '|> window(every: 20s, timeColumn: "_time") '
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

    public function testCorrectInstancesAreCreated()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->fromBucket('test_bucket')
            ->addRangeStart(new DateTime('2022-08-12 17:31:00'));

        $instances = [
            \Arendsen\FluxQueryBuilder\Functions\From::class,
            \Arendsen\FluxQueryBuilder\Functions\Range::class,
            \Arendsen\FluxQueryBuilder\Functions\Measurement::class,
        ];

        $requiredFluxQueryParts = $this->getClassProperty($queryBuilder, 'requiredFluxQueryParts');

        foreach ($requiredFluxQueryParts as $keyPart => $part) {
            $this->assertEquals($instances[$keyPart], $part);
        }
    }

    private function getClassProperty($object, string $property): array
    {
        $propertyReader = function & ($object, $property) {
            $value = & Closure::bind(function & () use ($property) {
                return $this->$property;
            }, $object, $object)->__invoke();

            return $value;
        };

        return $propertyReader($object, $property);
    }
}
