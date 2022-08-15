<?php

namespace Arendsen\FluxQueryBuilder;

use Arendsen\FluxQueryBuilder\Type\Time;
use DateTime;

class Type
{
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        switch (gettype($this->value)) {
            case 'string':
                return '"' . $this->value . '"';
            case 'object':
                if ($this->value instanceof DateTime) {
                    return new Time($this->value);
                }
                return $this->value->__toString();
            default:
                return (string)$this->value;
        }
    }
}
