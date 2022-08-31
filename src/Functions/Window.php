<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Type;
use Arendsen\FluxQueryBuilder\Type\ArrayType;
use Arendsen\FluxQueryBuilder\Type\DurationType;

class Window extends Base
{
    /**
     * @var string $every
     */
    private $every;

    /**
     * @var string|null $period
     */
    private $period;

    /**
     * @var string|null $offset
     */
    private $offset;

    /**
     * @var string|null $location
     */
    private $location;

    /**
     * @var string|null $timeColumn
     */
    private $timeColumn;

    /**
     * @var string|null $startColumn
     */
    private $startColumn;

    /**
     * @var string|null $stopColumn
     */
    private $stopColumn;

    /**
     * @var bool $createEmpty
     */
    private $createEmpty;

    public function __construct(
        $every,
        ?string $period = null,
        ?string $offset = null,
        ?string $location = null,
        ?string $timeColumn = null,
        ?string $startColumn = null,
        ?string $stopColumn = null,
        bool $createEmpty = false
    ) {
        $this->every = $every;
        $this->period = $period;
        $this->offset = $offset;
        $this->location = $location;
        $this->timeColumn = $timeColumn;
        $this->startColumn = $startColumn;
        $this->stopColumn = $stopColumn;
        $this->createEmpty = $createEmpty;
    }

    public function __toString()
    {
        $input = new ArrayType(array_filter([
            'every' => new DurationType($this->every),
            'period' => $this->period ? new DurationType($this->period) : null,
            'offset' => $this->offset ? new DurationType($this->offset) : null,
            'location' => $this->location ? new Type($this->location) : null,
            'timeColumn' => $this->timeColumn ? new Type($this->timeColumn) : null,
            'startColumn' => $this->startColumn ? new Type($this->startColumn) : null,
            'stopColumn' => $this->stopColumn ? new Type($this->stopColumn) : null,
            'createEmpty' => $this->createEmpty ? new Type($this->createEmpty) : null,
        ]));
        return '|> window(' . $input . ') ';
    }
}
