<?php

namespace Arendsen\FluxQueryBuilder\Expression;

use Exception;

class KeyValue extends Base {

    const EQUAL_TO = '==';
    const NOT_EQUAL_TO = '!=';
    const GREATER_THAN = '>';
    const GREATER_EQUAL_TO = '>=';
    const LESS_THAN = '<';
    const LESS_EQUAL_TO = '<=';
    const EQUAL_TO_REGEX = '=~';
    const NOT_EQUAL_TO_REGEX = '!~';

    const COMPARISON_OPERATORS = [
        self::EQUAL_TO,
        self::NOT_EQUAL_TO,
        self::GREATER_THAN,
        self::GREATER_EQUAL_TO,
        self::LESS_THAN,
        self::LESS_EQUAL_TO,
        self::EQUAL_TO_REGEX,
        self::NOT_EQUAL_TO_REGEX,
    ];

    /**
     * @var array $expressions
     */
    private $expressions;

    private function __construct(string $key, string $operator, string $value)
    {
        $this->checkOperator($operator);
        $this->expressions[] = 'r.' . $key . ' ' . $operator . ' "' . $value . '"';
    }

    public static function set(string $key, string $operator, string $value): KeyValue
    {
        return new self($key, $operator, $value);
    }

    public static function setEquals(string $key, string $value): KeyValue
    {
        return self::set($key, self::EQUAL_TO, $value);
    }

    public function and(string $key, string $operator, string $value): KeyValue
    {
        $this->checkOperator($operator);
        $this->expressions[] = 'and r.' . $key . ' ' . $operator . ' "' . $value . '"';
        return $this;
    }

    public function andEquals(string $key, string $value): KeyValue
    {
        $this->and($key, '==', $value);
        return $this;
    }

    public function or(string $key, string $operator, string $value): KeyValue
    {
        $this->checkOperator($operator);
        $this->expressions[] = 'or r.' . $key . ' ' . $operator . ' "' . $value . '"';
        return $this;
    }

    public function orEquals(string $key, string $value): KeyValue
    {
        $this->or($key, '==', $value);
        return $this;
    }

    public function __toString()
    {
        return implode(' ', $this->expressions);
    }

    protected function checkOperator(string $operator)
    {
        if(!in_array($operator, self::COMPARISON_OPERATORS))
        {
            throw new Exception('Operator "' . $operator . '" is not supported!');
        }
    }

}