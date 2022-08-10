<?php

namespace Arendsen\FluxQueryBuilder\Function;

abstract class Base {

	/**
	 * @throws FunctionNotImplementedException
	 */
	public function __toString()
    {
		throw new FunctionNotImplementedException('__toString', get_class($this));
	}

	protected function format(array $settings)
    {
        array_walk($settings, function(&$value, $key) {
			$value = $key . ': ' . (is_string($value) ? '"' . $value . '"' : $value);
		});

        return $settings;
    }

}