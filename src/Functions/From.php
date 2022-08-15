<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Formatters;

class From extends Base
{
    /**
     * @var array $settings
     */
    private $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public function __toString()
    {
        return 'from(' . Formatters::toFluxArrayString($this->settings) . ') ';
    }
}
