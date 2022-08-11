<?php

namespace Arendsen\FluxQueryBuilder\Function;

use Arendsen\FluxQueryBuilder\Formatters;

class Group extends Base {

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
        return '|> group(columns: [' . Formatters::toFluxArrayString($this->columns) . '], mode: "' . $this->mode . '") ';
    }

}