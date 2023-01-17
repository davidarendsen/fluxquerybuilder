<?php

namespace Arendsen\FluxQueryBuilder\Functions;

class Sum extends Base
{
    /**
     * @var string $column
     */
    private $column;

    public function __construct(string $column)
    {
        $this->column = $column;
    }

    public function __toString()
    {
        return '|> sum(column: "' . (string)$this->column . '") ';
    }
}
