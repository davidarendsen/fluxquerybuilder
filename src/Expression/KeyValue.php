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

    private function __construct(string $key, string $operator, $value)
    {
        $this->checkOperator($operator);
        $value = is_string($value) ? '"' . $value . '"' : $value;
        $this->expressions[] = 'r.' . $key . ' ' . $operator . ' ' . $value;
    }

    public static function set(string $key, string $operator, $value): KeyValue
    {
        return new self($key, $operator, $value);
    }

    public static function setEqualTo(string $key, string $value): KeyValue
    {
        return self::set($key, self::EQUAL_TO, $value);
    }

    public static function setNotEqualTo(string $key, string $value): KeyValue
    {
        return self::set($key, self::NOT_EQUAL_TO, $value);
    }

    public static function setGreaterThan(string $key, int $value): KeyValue
    {
        return self::set($key, self::GREATER_THAN, $value);
    }

    public static function setGreaterOrEqualTo(string $key, int $value): KeyValue
    {
        return self::set($key, self::GREATER_EQUAL_TO, $value);
    }

    public static function setLessThan(string $key, int $value): KeyValue
    {
        return self::set($key, self::LESS_THAN, $value);
    }

    public static function setLessOrEqualTo(string $key, int $value): KeyValue
    {
        return self::set($key, self::LESS_EQUAL_TO, $value);
    }

    public static function setEqualToRegex(string $key, string $value): KeyValue
    {
        return self::set($key, self::EQUAL_TO_REGEX, $value);
    }

    public static function setNotEqualToRegex(string $key, string $value): KeyValue
    {
        return self::set($key, self::NOT_EQUAL_TO_REGEX, $value);
    }

    public function and(string $key, string $operator, $value): KeyValue
    {
        $this->checkOperator($operator);
        $value = is_string($value) ? '"' . $value . '"' : $value;
        $this->expressions[] = 'and r.' . $key . ' ' . $operator . ' ' . $value;
        return $this;
    }

    public function andEqualTo(string $key, string $value): KeyValue
    {
        $this->and($key, self::EQUAL_TO, $value);
        return $this;
    }

    public function andNotEqualTo(string $key, string $value): KeyValue
    {
        $this->and($key, self::NOT_EQUAL_TO, $value);
        return $this;
    }

    public function andGreaterThan(string $key, int $value): KeyValue
    {
        $this->and($key, self::GREATER_THAN, $value);
        return $this;
    }

    public function andGreaterOrEqualTo(string $key, int $value): KeyValue
    {
        $this->and($key, self::GREATER_EQUAL_TO, $value);
        return $this;
    }

    public function andLessThan(string $key, int $value): KeyValue
    {
        $this->and($key, self::LESS_THAN, $value);
        return $this;
    }

    public function andLessOrEqualTo(string $key, int $value): KeyValue
    {
        $this->and($key, self::LESS_EQUAL_TO, $value);
        return $this;
    }

    public function andEqualToRegex(string $key, string $value): KeyValue
    {
        $this->and($key, self::EQUAL_TO_REGEX, $value);
        return $this;
    }

    public function andNotEqualToRegex(string $key, string $value): KeyValue
    {
        $this->and($key, self::NOT_EQUAL_TO_REGEX, $value);
        return $this;
    }

    public function or(string $key, string $operator, $value): KeyValue
    {
        $this->checkOperator($operator);
        $value = is_string($value) ? '"' . $value . '"' : $value;
        $this->expressions[] = 'or r.' . $key . ' ' . $operator . ' ' . $value;
        return $this;
    }

    public function orEqualTo(string $key, string $value): KeyValue
    {
        $this->or($key, self::EQUAL_TO, $value);
        return $this;
    }

    public function orNotEqualTo(string $key, string $value): KeyValue
    {
        $this->or($key, self::NOT_EQUAL_TO, $value);
        return $this;
    }

    public function orGreaterThan(string $key, int $value): KeyValue
    {
        $this->or($key, self::GREATER_THAN, $value);
        return $this;
    }

    public function orGreaterOrEqualTo(string $key, int $value): KeyValue
    {
        $this->or($key, self::GREATER_EQUAL_TO, $value);
        return $this;
    }

    public function orLessThan(string $key, int $value): KeyValue
    {
        $this->or($key, self::LESS_THAN, $value);
        return $this;
    }

    public function orLessOrEqualTo(string $key, int $value): KeyValue
    {
        $this->or($key, self::LESS_EQUAL_TO, $value);
        return $this;
    }

    public function orEqualToRegex(string $key, string $value): KeyValue
    {
        $this->or($key, self::EQUAL_TO_REGEX, $value);
        return $this;
    }

    public function orNotEqualToRegex(string $key, string $value): KeyValue
    {
        $this->or($key, self::NOT_EQUAL_TO_REGEX, $value);
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