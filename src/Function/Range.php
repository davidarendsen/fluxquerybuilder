<?php

namespace Arendsen\FluxQueryBuilder\Function;

use Arendsen\FluxQueryBuilder\Formatters;

class Range extends Base {

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
        return '|> range(' . Formatters::toFluxAssociativeArrayString($this->settings) . ') ';
    }

}