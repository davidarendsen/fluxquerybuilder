<?php

namespace Arendsen\FluxQueryBuilder;

use Arendsen\FluxQueryBuilder\Type\ArrayType;
use DateTime;
use Arendsen\FluxQueryBuilder\Type\Time;

class Formatters
{
    public static function valueToString($value): string
    {
        return new Type($value);
    }

    public static function toFluxArrayString(array $array): string
    {
        return new Type($array);
    }

    public static function dateTimeToString(DateTime $dateTime): string
    {
        return new Type($dateTime);
    }
}
