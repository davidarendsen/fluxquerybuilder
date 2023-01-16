<?php

namespace Arendsen\FluxQueryBuilder;

use Exception;
use Arendsen\FluxQueryBuilder\Builder\QueryBuilderInterface;
use Arendsen\FluxQueryBuilder\Builder\Basics;
use Arendsen\FluxQueryBuilder\Builder\Universe;

class QueryBuilder implements QueryBuilderInterface
{
    use Basics;
    use Universe;

    /**
     * @var array $requiredFluxQueryParts
     */
    private $requiredFluxQueryParts = [];

    /**
     * @var array $fluxQueryParts
     */
    private $fluxQueryParts = [];

    /**
     * @var array $requiredData
     */
    private $requiredData = [];

    protected function addToQuery($query)
    {
        $this->fluxQueryParts[] = $query;

        foreach ($this->requiredFluxQueryParts as $input) {
            if ($query instanceof $input) {
                $this->requiredData[] = $query;
            }
        }
    }

    public function build(): string
    {
        $this->checkRequired();

        $query = '';

        foreach ($this->fluxQueryParts as $part) {
            $query .= $part;
        }

        return $query;
    }

    protected function checkRequired()
    {
        foreach ($this->requiredFluxQueryParts as $key => $input) {
            if (isset($this->requiredData[$key]) && !$this->requiredData[$key] instanceof $input) {
                throw new Exception('You need to put the "' . $input . '" part of the query in the correct order!');
            } elseif (!isset($this->requiredData[$key])) {
                throw new Exception('You need to define the "' . $input . '" part of the query!');
            }
        }
    }
}
