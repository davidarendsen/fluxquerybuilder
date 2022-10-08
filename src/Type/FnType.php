<?php

namespace Arendsen\FluxQueryBuilder\Type;

class FnType implements TypeInterface
{
    /**
     * @var mixed $value
     */
    protected $value;

    /**
     * @var string $content
     */
    protected $content;

    public function __construct($value, string $content = '')
    {
        $this->value = $value;
        $this->content = $content;
    }

    public function __toString(): string
    {
        if (is_string($this->value)) {
            return $this->value;
        }

        return '(' . implode(', ', $this->value) . ') => ' . $this->content;
    }
}
