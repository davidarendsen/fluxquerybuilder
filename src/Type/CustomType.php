<?php

namespace Arendsen\FluxQueryBuilder\Type;

class CustomType implements TypeInterface
{
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
