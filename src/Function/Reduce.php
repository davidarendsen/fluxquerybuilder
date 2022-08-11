<?php

namespace Arendsen\FluxQueryBuilder\Function;

use Arendsen\FluxQueryBuilder\Formatters;

class Reduce extends Base {

    /**
     * @var array $settings
     */
    private $settings;

    /**
     * @var array $identity
     */
    private $identity;

    public function __construct(array $settings, array $identity)
    {
        $this->settings = $settings;
        $this->identity = $identity;
    }

    public function __toString()
    {
        return '|> reduce(fn: (r, accumulator) => ({' . implode(', ', $this->formatSettings($this->settings)) . '}), ' . 
            'identity: {' . Formatters::toFluxArrayString($this->identity) . '}) ';
    }

    protected function formatSettings(array $settings)
    {
        array_walk($settings, function(&$value, $key) {
			$value = $key . ': ' . $value;
		});

        return $settings;
    }

}