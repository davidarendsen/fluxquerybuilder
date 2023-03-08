<?php

namespace Arendsen\FluxQueryBuilder\Type;

use Arendsen\FluxQueryBuilder\Type;

class FnType implements TypeInterface
{
    /**
     * @var array $params
     */
    protected $params;

    /**
     * @var string $content
     */
    protected $content;

    private function __construct(array $params)
    {
        $this->params = $params;
    }

    public static function params(array $params)
    {
        return new self($params);
    }

    public function withBody(string $content)
    {
        $this->content = $content;
        return $this;
    }

    public function withBlock(string $content)
    {
        $this->content = '{ ' . $content . ' }';
        return $this;
    }

    public function __toString(): string
    {
        array_walk($this->params, function (&$value, $key) {
            if (is_string($key)) {
                $value = $key . ' = ' . new Type($value);
            }
        });

        return '(' . implode(', ', $this->params) . ') => ' . $this->content;
    }
}
