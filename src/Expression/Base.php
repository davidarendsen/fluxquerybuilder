<?php

namespace Arendsen\FluxQueryBuilder\Expression;

use Arendsen\FluxQueryBuilder\Exception\ExpressionNotImplementedException;

abstract class Base
{
    /**
     * @throws ExpressionNotImplementedException
     */
    public function __toString()
    {
        throw new ExpressionNotImplementedException('__toString', get_class($this));
    }
}
