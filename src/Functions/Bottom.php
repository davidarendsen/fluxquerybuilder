<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Type\ArrayType;

class Bottom extends Base
{
    /**
     * @var int $n
     */
    private $n;

    /**
     * @var array $columns
     */
    private $columns;

    public function __construct($n, array $columns = [])
    {
        $this->n = $n;
        $this->columns = $columns;
    }

    public function __toString()
    {
        $input = new ArrayType(array_filter([
            'n' => $this->n,
            'columns' => $this->columns ?: null,
        ]));
        return '|> bottom(' . $input . ') ';
    }
}
