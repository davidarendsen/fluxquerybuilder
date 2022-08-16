<?php

namespace Arendsen\FluxQueryBuilder\Type;

class BooleanType implements TypeInterface
{
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value ? 'true' : 'false';
    }
}
