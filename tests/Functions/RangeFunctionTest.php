<?php
declare(strict_types=1);

use Arendsen\FluxQueryBuilder\Exception\FunctionRequiredSettingMissingException;
use Arendsen\FluxQueryBuilder\Functions\Range;
use PHPUnit\Framework\TestCase;

final class RangeFunctionTest extends TestCase {

    public function testOnlyStartOption()
    {
        $expression = new Range(['start' => '-360h']);

        $query = '|> range(start: -360h) ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testWithStopOption()
    {
        $expression = new Range(['start' => '-360h', 'stop' => 'now()']);

        $query = '|> range(start: -360h, stop: now()) ';

        $this->assertEquals($query, $expression->__toString());
    }

    public function testThrowsExceptionWhenStartIsMissing()
    {
        $this->expectException(FunctionRequiredSettingMissingException::class);

        $expression = new Range(['stop' => 'now()']);
        $expression->__toString();
    }

}