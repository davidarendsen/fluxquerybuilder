<?php

namespace Arendsen\FluxQueryBuilder;

use Arendsen\FluxQueryBuilder\Type\ArrayType;
use Arendsen\FluxQueryBuilder\Type\BooleanType;
use Arendsen\FluxQueryBuilder\Type\TimeType;
use DateTime;

class Type
{
    /**
     * @var mixed $value
     */
    protected $value;

    /**
     * @var Settings|null $settings
     */
    protected $settings;

    public function __construct($value, Settings $settings = null)
    {
        $this->value = $value;
        $this->settings = $settings ? $settings : Settings::set([]);
    }

    public function __toString(): string
    {
        switch (gettype($this->value)) {
            case 'object':
                if ($this->value instanceof DateTime) {
                    return new TimeType($this->value);
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
