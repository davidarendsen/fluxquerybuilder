<?php

namespace Arendsen\FluxQueryBuilder\Function;

class Sort extends Base {

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
        $columns = array_map(function($column) {
			return '"' . $column . '"';
		}, $this->columns);
        $desc = $this->desc ? 'true' : 'false';

        return '|> sort(columns: [' . implode(', ', $columns) . '], desc: ' . $desc . ') ';
    }

}