<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Type;
use Arendsen\FluxQueryBuilder\Type\ArrayType;

class Mean extends Base
{
    /**
     * @var string $column
     */
    private $column;

    public function __construct(string $column = '_value')
    {
        $this->column = $column;
    }

    public function __toString()
    {
        $input = new ArrayType(array_filter([
            'column' => !empty($this->column) && $this->column !== '_value'  ?
                new Type($this->column) : null
        ]));

        return '|> mean(' . $input . ') ';
    }
}
