<?php

namespace Arendsen\FluxQueryBuilder;

use DateTime;
use Arendsen\FluxQueryBuilder\Type\Time;

class Formatters
{
    public static function valueToString($value): string
    {
        if (is_string($value)) {
            return '"' . $value . '"';
        } elseif (is_bool($value)) {
            return $value ? 'true' : 'false';
        } elseif (is_array($value)) {
            return '[' . self::toFluxArrayString($value) . ']';
        }

        return $value;
    }

    public static function toFluxArrayString(array $array): string
    {
        array_walk($array, function (&$value, $key) {
            if (is_string($key)) {
                $value = $key . ': ' . self::valueToString($value);
            } else {
                $value = self::valueToString($value);
            }
        });

        return implode(', ', $array);
    }

    public static function dateTimeToString(DateTime $dateTime): string
    {
        return new Type($dateTime);
    }
}
