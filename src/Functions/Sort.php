<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Formatters;

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
        return '|> sort(columns: [' . Formatters::toFluxArrayString($this->columns) .
            '], desc: ' . Formatters::valueToString($this->desc) . ') ';
    }
}
