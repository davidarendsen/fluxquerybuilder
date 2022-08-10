<?php

namespace Arendsen\FluxQueryBuilder\Function;

class From extends Base {

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
        return 'from(' . implode(', ', $this->format($this->settings)) . ') ';
    }

}