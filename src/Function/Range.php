<?php

namespace Arendsen\FluxQueryBuilder\Function;

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
        return '|> range(' . implode(', ', $this->format($this->settings)) . ') ';
    }

}