<?php

namespace Arendsen\FluxQueryBuilder\Function;

class Filter extends Base {

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
        return '|> filter(fn: (r) => ' . implode(' ', $this->settings) . ') ';
    }

}