<?php

namespace Arendsen\FluxQueryBuilder\Type;

use Arendsen\FluxQueryBuilder\Type;

class RecordType implements TypeInterface
{
    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        array_walk($this->value, function (&$value, $key) {
            if (is_string($key)) {
                $value = $key . ': ' . new Type($value, [
                    'isRecord' => true,
                ]);
            } else {
                $value = new Type($value, [
                    'isRecord' => true,
                ]);
            }
        });

        return '{' . implode(', ', $this->value) . '}';
    }
}
