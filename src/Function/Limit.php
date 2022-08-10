<?php

namespace Arendsen\FluxQueryBuilder\Function;

class Limit extends Base {

    /**
     * @var int $limit
     */
    private $limit;

    public function __construct(int $limit)
    {
        $this->limit = $limit;
    }

    public function __toString()
    {
        return '|> limit(n:' . (string)$this->limit . ') ';
    }

}