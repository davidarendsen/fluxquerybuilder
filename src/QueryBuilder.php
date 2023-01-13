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

    public const REQUIRED_INPUT_FROM = 'from';
    public const REQUIRED_INPUT_RANGE = 'range';
    public const REQUIRED_INPUT_MEASUREMENT = 'measurement';

    public const REQUIRED_INPUT = [
        self::REQUIRED_INPUT_FROM,
        self::REQUIRED_INPUT_RANGE,
        self::REQUIRED_INPUT_MEASUREMENT,
    ];

    /**
     * @var int $currentFluxQueryPart
     */
    private $currentFluxQueryPart = 0;

    /**
     * @var array $fluxQuery
     */
    private $fluxQueryParts = [];

    /**
     * @var array $requiredData
     */
    private $requiredData = [];

    protected function addToQuery($key, $query)
    {
        $this->fluxQueryParts[$this->currentFluxQueryPart] = $query;
        $this->currentFluxQueryPart++;
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

    protected function addRequiredData(string $key, $value)
    {
        $this->requiredData[][$key] = $value;
    }

    protected function checkRequired()
    {
        foreach (self::REQUIRED_INPUT as $key => $input) {
            if (!isset($this->requiredData[$key][$input])) {
                throw new Exception('You need to define the "' . $input . '" part of the query!');
            }
        }
    }
}
