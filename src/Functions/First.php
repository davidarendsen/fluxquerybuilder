<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Type;

class First extends Base
{
    /**
     * @var string|null $column
     */
    private $column;

    public function __construct(?string $column = null)
    {
        $this->column = $column;
    }

    public function __toString()
    {
        $params = new Type(array_filter([
          'column' => $this->column
        ]));

        return '|> first(' . $params . ') ';
    }
}
