<?php

namespace Arendsen\FluxQueryBuilder\Type;

class DurationType implements TypeInterface
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
