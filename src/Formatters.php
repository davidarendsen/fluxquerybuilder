<?php

namespace Arendsen\FluxQueryBuilder;

class Formatters {

    public static function valueToString($value): string
    {
        if(is_string($value))
        {
            return '"' . $value . '"';
        }
        elseif(is_bool($value))
        {
            return $value ? 'true' : 'false';
        }

        return $value;
    }

    public static function toFluxArrayString(array $array): string
    {
        $array = array_map(function($column) {
            return self::valueToString($column);
		}, $array);

        return implode(', ', $array);
    }

    public static function toFluxAssociativeArrayString(array $array): string
    {
        array_walk($array, function(&$value, $key) {
			$value = $key . ': ' . self::valueToString($value);
		});

        return implode(', ', $array);
    }

}