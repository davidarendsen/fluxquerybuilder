<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Expression\Map as MapExpression;

class Map extends Base
{
    /**
     * @var mixed $query
     */
    private $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function __toString()
    {
        return '|> map(fn: (r) => ({ ' . $this->query . ' })) ';
    }
}
