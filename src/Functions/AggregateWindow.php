<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Type;
use Arendsen\FluxQueryBuilder\Type\ArrayType;
use Arendsen\FluxQueryBuilder\Type\DurationType;
use Arendsen\FluxQueryBuilder\Type\FnType;

class AggregateWindow extends Base
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
     * @var string|null $column
     */
    private $column;

    /**
     * @var string|null $timeSrc
     */
    private $timeSrc;

    /**
     * @var string|null $timeDst
     */
    private $timeDst;

    /**
     * @var bool $createEmpty
     */
    private $createEmpty;

    public function __construct(
        $every,
        ?string $period = null,
        ?string $offset = null,
        $fn,
        ?string $location = null,
        ?string $column = null,
        ?string $timeSrc = null,
        ?string $timeDst = null,
        bool $createEmpty = true
    ) {
        $this->every = $every;
        $this->period = $period;
        $this->offset = $offset;
        $this->fn = $fn;
        $this->location = $location;
        $this->column = $column;
        $this->timeSrc = $timeSrc;
        $this->timeDst = $timeDst;
        $this->createEmpty = $createEmpty;
    }

    public function __toString()
    {
        $input = new ArrayType(array_filter([
            'every' => new DurationType($this->every),
            'period' => $this->period ? new DurationType($this->period) : null,
            'offset' => $this->offset ? new DurationType($this->offset) : null,
            'fn' => new FnType($this->fn),
            'location' => $this->location ? new Type($this->location) : null,
            'column' => $this->column ? new Type($this->column) : null,
            'timeSrc' => $this->timeSrc ? new Type($this->timeSrc) : null,
            'timeDst' => $this->timeDst ? new Type($this->timeDst) : null,
            'createEmpty' => !$this->createEmpty ? new Type($this->createEmpty) : null,
        ]));
        return '|> aggregateWindow(' . $input . ') ';
    }
}
