<?php

namespace Arendsen\FluxQueryBuilder\Expression;

use Arendsen\FluxQueryBuilder\Type\FieldRecordType;

class Map extends Base
{
    private static $string;

    public static function with(string $name, string $content): Map
    {
        self::$string = 'r with ' . $name . ': ' . $content;
        return new self();
    }

    public static function columns(array $columns)
    {
        self::$string = new FieldRecordType($columns);
        return new self();
    }

    public function __toString()
    {
        return self::$string;
    }
}
