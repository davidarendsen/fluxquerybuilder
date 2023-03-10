<?php

namespace Arendsen\FluxQueryBuilder\Type;

use Arendsen\FluxQueryBuilder\Type;

class RecordType implements TypeInterface
{
    /**
     * @var array $value
     */
    private $value;

    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        array_walk($this->value, function (&$value, $key) {
            if (is_array($value)) {
                $value = $this->getPrefix($key) . new RecordType($value);
            } else {
                $value = $this->getPrefix($key) . new Type($value);
            }
        });

        return '{' . implode(', ', $this->value) . '}';
    }

    private function getPrefix($key): string
    {
        return is_string($key) ? $key . ': ' : '';
    }
}
