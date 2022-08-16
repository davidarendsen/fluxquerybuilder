<?php

namespace Arendsen\FluxQueryBuilder;

use Arendsen\FluxQueryBuilder\Type\ArrayType;
use DateTime;
use Arendsen\FluxQueryBuilder\Type\Time;

class Formatters
{
    public static function valueToString($value): string
    {
        if (is_array($value)) {
            return '[' . new ArrayType($value) . ']';
        } else {
            return new Type($value);
        }

        return $value;
    }

    public static function toFluxArrayString(array $array): string
    {
        return new ArrayType($array);
    }

    public static function dateTimeToString(DateTime $dateTime): string
    {
        return new Type($dateTime);
    }
}
