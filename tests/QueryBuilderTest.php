<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Arendsen\FluxQueryBuilder\QueryBuilder;

final class QueryBuilderTest extends TestCase {

    /**
     * @dataProvider somethingProvider
     */
    public function testSomething($bucket, $measurement, $range, $expectedQuery)
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder->from($bucket)
            ->fromMeasurement($measurement)
			->addRangeStart($range);

        $this->assertEquals($queryBuilder->build(), $expectedQuery);
    }

    public function somethingProvider(): array
    {
        return [
            'case 1' => [
                [
                    'bucket' => 'example-bucket', 
                    'host' => 'host', 
                    'org' => 'example-org', 
                    'token' => 'token'
                ],
                'test_measurement',
                '-360h',
                'from(bucket: "test_bucket", host: "host", org: "example-org", token: "token") |> '
            ],
        ];
    }

}