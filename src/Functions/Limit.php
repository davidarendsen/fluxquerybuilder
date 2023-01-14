<?php

namespace Arendsen\FluxQueryBuilder\Functions;

class Limit extends Base
{
    /**
     * @var int $limit
     */
    private $limit;

    /**
     * @var int $offset
     */
    private $offset;

    public function __construct(int $limit, int $offset = 0)
    {
        $this->limit = $limit;
        $this->offset = $offset;
    }

    public function __toString()
    {
        return '|> limit(n: ' . (string)$this->limit . ', offset: ' . (string)$this->offset . ') ';
    }
}
