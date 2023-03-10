<?php

namespace Arendsen\FluxQueryBuilder\Type;

use Arendsen\FluxQueryBuilder\Settings;
use Arendsen\FluxQueryBuilder\Type;

class ArrayType implements TypeInterface
{
    /**
     * @var array $value
     */
    protected $value;

    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        array_walk($this->value, function (&$value, $key) {
            if ($this->isAssociativeArray($key)) {
                $value = $key . ': ' . $this->getPrefix($value) . new Type($value) . $this->getSuffix($value);
            } else {
                $value = $this->getPrefix($value) . new Type($value) . $this->getSuffix($value);
            }
        });

        return implode(', ', $this->value);
    }

    protected function isAssociativeArray($key): bool
    {
        return is_string($key);
    }

    protected function getPrefix($value): string
    {
        return is_array($value) ? '[' : '';
    }

    protected function getSuffix($value): string
    {
        return is_array($value) ? ']' : '';
    }
}
