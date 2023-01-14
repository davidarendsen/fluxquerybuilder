<?php

namespace Arendsen\FluxQueryBuilder\Functions;

class Measurement extends Base
{
    /**
     * @var string $measurement
     */
    private $measurement;

    public function __construct(string $measurement)
    {
        $this->measurement = $measurement;
    }

    public function __toString()
    {
        return '|> filter(fn: (r) => r._measurement == "' . (string)$this->measurement . '") ';
    }
}
