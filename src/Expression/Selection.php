<?php

namespace Arendsen\FluxQueryBuilder\Expression;

use Arendsen\FluxQueryBuilder\Type;

class Selection extends Base
{
    private $string;

    private function __construct(string $string)
    {
        $this->string = $string;
    }

    public static function if(string $value): Selection
    {
        return new self('if ' . $value);
    }

    public function then($then): Selection
    {
        $this->string .= ' then ' . new Type($then);
        return $this;
    }

    public function else($else): Selection
    {
        $this->string .= ' else ' . new Type($else);
        return $this;
    }

    public function __toString()
    {
        return $this->string;
    }
}
