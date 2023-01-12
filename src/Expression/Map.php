<?php

namespace Arendsen\FluxQueryBuilder\Expression;

use Arendsen\FluxQueryBuilder\Type\FieldRecordType;

class Map extends Base
{
    private static $string;

    public static function with(string $name, string $content): Map
    {
        $object = new self();
        $object::$string = 'r with ' . $name . ': ' . $content;
        return $object;
    }

    public static function columns(array $columns)
    {
        $object = new self();
        $object::$string = new FieldRecordType($columns);
        return $object;
    }

    public function __toString()
    {
        return self::$string;
    }
}
