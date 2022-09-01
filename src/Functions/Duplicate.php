<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Type;
use Arendsen\FluxQueryBuilder\Type\ArrayType;

class Duplicate extends Base
{
    /**
     * @var string $column
     */
    private $column;

    /**
     * @var string $as
     */
    private $as;

    public function __construct(string $column, string $as)
    {
        $this->column = $column;
        $this->as = $as;
    }

    public function __toString()
    {
        $input = new ArrayType([
            'column' => $this->column,
            'as' => $this->as
        ]);

        return '|> duplicate(' . $input . ') ';
    }
}
