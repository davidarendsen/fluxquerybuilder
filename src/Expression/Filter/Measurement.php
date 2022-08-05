<?php

namespace Arendsen\FluxQueryBuilder\Expression\Filter;

use Arendsen\FluxQueryBuilder\Expression\Base;

class Measurement extends Base {

    /**
     * @var array $measurement
     */
    private $measurement;

    public function __construct(string $measurement)
    {
        $this->measurement = $measurement;
    }

    public function __toString()
    {
        return 'r._measurement == "' . $this->measurement . '"';
    }

}