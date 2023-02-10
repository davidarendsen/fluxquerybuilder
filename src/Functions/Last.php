<?php

namespace Arendsen\FluxQueryBuilder\Functions;

class Last extends Base
{
	/**
	 * @var int $column
	 */
	private $column;

	public function __construct(string $column = '_value')
	{
		$this->column = $column;
	}

	public function __toString()
	{
		return '|> last(column: "' . (string)$this->column . '") ';
	}
}
