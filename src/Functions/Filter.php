<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Expression\KeyValue;

class Filter extends Base {

    /**
     * @var KeyValue $keyValue
     */
    private $keyValue;

    public function __construct(KeyValue $keyValue)
    {
        $this->keyValue = $keyValue;
    }

    public function __toString()
    {
        return '|> filter(fn: (r) => ' . $this->keyValue . ') ';
    }

}