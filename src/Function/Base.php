<?php

namespace Arendsen\FluxQueryBuilder\Function;

use Arendsen\FluxQueryBuilder\Formatters;

abstract class Base {

	/**
	 * @throws FunctionNotImplementedException
	 */
	public function __toString()
    {
		throw new FunctionNotImplementedException('__toString', get_class($this));
	}

}