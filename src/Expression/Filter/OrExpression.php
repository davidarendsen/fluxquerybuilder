<?php

namespace Arendsen\FluxQueryBuilder\Expression\Filter;

use Arendsen\FluxQueryBuilder\Expression\Base;

class OrExpression extends Base {

    /**
     * @var string $key
     */
    private $key;

    /**
     * @var string $value
     */
    private $value;

    public function __construct(string $key, string $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public function __toString()
    {
        return 'or r.' . $this->key . ' == "' . $this->value . '"';
    }

}