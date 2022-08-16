<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Type;

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
        $array = new Type([
            'columns' => $this->columns,
            'mode' => $this->mode,
        ]);

        return '|> group(' . $array . ') ';
    }
}
