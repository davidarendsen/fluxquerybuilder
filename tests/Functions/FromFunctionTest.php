<?php

declare(strict_types=1);

namespace Tests\Functions;

use Arendsen\FluxQueryBuilder\Functions\From;
use PHPUnit\Framework\TestCase;

final class FromFunctionTest extends TestCase
{
    /**
     * @dataProvider somethingProvider
     */
    public function testSomething($settings, $query)
    {
        $expression = new From($settings);

        $this->assertEquals($expression->__toString(), $query);
    }

    public function somethingProvider(): array
    {
        return [
            'from bucket' => [
                [
                    'bucket' => 'test-bucket',
                ],
                'from(bucket: "test-bucket") '
            ],
            'from bucket and host' => [
                [
                    'bucket' => 'test-bucket',
                    'host' => 'test',
                ],
                'from(bucket: "test-bucket", host: "test") '
            ],
        ];
    }
}
