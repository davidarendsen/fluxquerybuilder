<?php

namespace Arendsen\FluxQueryBuilder;

use Exception;
use Arendsen\FluxQueryBuilder\Builder\QueryBuilderInterface;
use Arendsen\FluxQueryBuilder\Builder\Basics;
use Arendsen\FluxQueryBuilder\Builder\Universe;
use Arendsen\FluxQueryBuilder\Functions\From;
use Arendsen\FluxQueryBuilder\Functions\Measurement;
use Arendsen\FluxQueryBuilder\Functions\Range;

class QueryBuilder implements QueryBuilderInterface
{
    use Basics;
    use Universe;

    /**
     * The required Flux query parts and the correct order.
     * Depends on Basics trait
     */
    public const REQUIRED_FLUX_QUERY_PARTS = [
        From::class,
        Range::class,
        Measurement::class,
    ];

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

        foreach (self::REQUIRED_FLUX_QUERY_PARTS as $input) {
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
        foreach (self::REQUIRED_FLUX_QUERY_PARTS as $key => $input) {
            if (isset($this->requiredData[$key]) && !$this->requiredData[$key] instanceof $input) {
                throw new Exception('You need to put the "' . $input . '" part of the query in the correct order!');
            } elseif (!isset($this->requiredData[$key])) {
                throw new Exception('You need to define the "' . $input . '" part of the query!');
            }
        }
    }
}
