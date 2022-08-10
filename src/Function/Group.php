<?php

namespace Arendsen\FluxQueryBuilder\Function;

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
        $columns = array_map(function($column) {
			return '"' . $column . '"';
		}, $this->columns);

        return '|> group(columns: [' . implode(', ', $columns) . '], mode: "' . $this->mode . '") ';
    }

}