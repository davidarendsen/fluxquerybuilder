<?php

namespace Arendsen\FluxQueryBuilder\Type;

use Arendsen\FluxQueryBuilder\Formatters;
use Arendsen\FluxQueryBuilder\Type;

class ArrayType implements TypeInterface
{
    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        array_walk($this->value, function (&$value, $key) {
            if (is_string($key)) {
                $value = $key . ': ' . Formatters::valueToString($value);
            } else {
                $value = Formatters::valueToString($value);
            }
        });

        return implode(', ', $this->value);
    }
}
