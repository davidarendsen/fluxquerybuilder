<?php

namespace Arendsen\FluxQueryBuilder\Functions;

class Map extends Base {

    /**
     * @var array $query
     */
    private $query;

    public function __construct(string $query)
    {
        $this->query = $query;
    }

    public function __toString()
    {
        return '|> map(fn: (r) => ({ ' . $this->query . ' })) ';
    }

}