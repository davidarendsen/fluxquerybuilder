<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Formatters;

class Group extends Base
{
    /**
     * @var array $columns
     */
    private $columns;

    /**
     * @var string $mode
     */
    private $mode;

    public function __construct(array $columns, string $mode = 'by')
    {
        $this->columns = $columns;
        $this->mode = $mode;
    }

    public function __toString()
    {
        $array = Formatters::toFluxArrayString([
            'columns' => $this->columns,
            'mode' => $this->mode,
        ]);

        return '|> group(' . $array . ') ';
    }
}
