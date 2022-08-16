<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Type;

class Sort extends Base
{
    /**
     * @var array $columns
     */
    private $columns;

    /**
     * @var bool $desc
     */
    private $desc;

    public function __construct(array $columns, bool $desc = false)
    {
        $this->columns = $columns;
        $this->desc = $desc;
    }

    public function __toString()
    {
        return '|> sort(columns: [' . new Type($this->columns) .
            '], desc: ' . new Type($this->desc) . ') ';
    }
}
