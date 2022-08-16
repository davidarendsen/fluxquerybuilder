<?php

namespace Arendsen\FluxQueryBuilder;

use Arendsen\FluxQueryBuilder\Type\ArrayType;
use Arendsen\FluxQueryBuilder\Type\BooleanType;
use Arendsen\FluxQueryBuilder\Type\Time;
use DateTime;

class Type
{
    public function __construct($value, $settings = [])
    {
        $this->value = $value;
        $this->settings = $settings;
    }

    public function __toString(): string
    {
        switch (gettype($this->value)) {
            case 'object':
                if ($this->value instanceof DateTime) {
                    return new Time($this->value);
                }
                return $this->value->__toString();
            case 'string':
                return '"' . $this->value . '"';
            case 'boolean':
                return new BooleanType($this->value);
            case 'array':
                return new ArrayType($this->value, $this->settings);
            default:
                return (string)$this->value;
        }
    }
}
