<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Exception\FunctionInvalidInputException;
use Arendsen\FluxQueryBuilder\Expression\KeyValue;
use Arendsen\FluxQueryBuilder\Expression\KeyFilter;

class Filter extends Base
{
    /**
     * @var mixed $filter
     */
    private $filter;

    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    public function __toString()
    {
        return '|> filter(fn: (r) => ' . $this->format() . ') ';
    }

    /**
     * @throws FunctionInvalidInputException
     */
    protected function format(): string
    {
        if ($this->filter instanceof KeyValue || $this->filter instanceof KeyFilter) {
            return $this->filter->__toString();
        } elseif (is_array($this->filter)) {
            $filterCounter = 0;
            $filterString = '';
            foreach ($this->filter as $filter) {
                if ($filterCounter > 0) {
                    $filterString .= ' or ';
                }

                $filterString .= 'r._field == "' . $filter . '"';

                $filterCounter++;
            }

            return $filterString;
        }

        throw new FunctionInvalidInputException('Filter input is incorrect.');
    }
}
