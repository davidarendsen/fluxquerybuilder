<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Formatters;
use Arendsen\FluxQueryBuilder\Function\FunctionNotImplementedException;

abstract class Base {

	/**
	 * @throws FunctionNotImplementedException
	 */
	public function __toString()
    {
		throw new FunctionNotImplementedException('__toString', get_class($this));
	}

}