<?php

namespace Arendsen\FluxQueryBuilder\Expression;

class KeyValue extends Base {

    /**
     * @var array $expressions
     */
    private $expressions;

    public function __construct(string $key, string $value)
    {
        $this->expressions[] = 'r.' . $key . ' == "' . $value . '"';
    }

    public static function set(string $key, string $value): KeyValue
    {
        return new self($key, $value);
    }

    public function and(string $key, string $value): KeyValue
    {
        $this->expressions[] = 'and r.' . $key . ' == "' . $value . '"';
        return $this;
    }

    public function or(string $key, string $value): KeyValue
    {
        $this->expressions[] = 'or r.' . $key . ' == "' . $value . '"';
        return $this;
    }

    public function __toString()
    {
        return implode(' ', $this->expressions);
    }

}