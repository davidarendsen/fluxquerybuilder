<?php

namespace Arendsen\FluxQueryBuilder\Functions;

class RawFunction extends Base
{
    /**
     * @var string $input
     */
    private $input;

    public function __construct(string $input)
    {
        $this->input = $input;
    }

    public function __toString()
    {
        return $this->input . ' ';
    }
}
