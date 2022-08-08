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

    protected function format(array $settings)
    {
        array_walk($settings, function(&$value, $key) {
			$value = $key . ': ' . (is_string($value) ? '"' . $value . '"' : $value);
		});

        return $settings;
    }

}