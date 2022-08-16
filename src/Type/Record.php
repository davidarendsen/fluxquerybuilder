<?php

namespace Arendsen\FluxQueryBuilder\Type;

use Arendsen\FluxQueryBuilder\Type;

class Record implements TypeInterface
{
    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        array_walk($this->value, function (&$value, $key) {
            if (is_string($key)) {
                $value = $key . ': ' . new Type($value);
            } else {
                $value = new Type($value);
            }
        });

        return '{' . implode(', ', $this->value) . '}';
    }
}
