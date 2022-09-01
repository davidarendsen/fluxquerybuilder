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
     * @var string $fn
     */
    private $fn;

    /**
     * @var array $options
     */
    private $options;

    public function __construct($every, $fn, array $options = [])
    {
        $this->every = $every;
        $this->fn = $fn;
        $this->options = $options;
    }

    public function __toString()
    {
        $input = new ArrayType(array_filter([
            'every' => new DurationType($this->every),
            'period' => isset($this->options['period']) ? new DurationType($this->options['period']) : null,
            'offset' => isset($this->options['offset']) ? new DurationType($this->options['offset']) : null,
            'fn' => new FnType($this->fn),
            'location' => isset($this->options['location']) ? new Type($this->options['location']) : null,
            'column' => isset($this->options['column']) ? new Type($this->options['column']) : null,
            'timeSrc' => isset($this->options['timeSrc']) ? new Type($this->options['timeSrc']) : null,
            'timeDst' => isset($this->options['timeDst']) ? new Type($this->options['timeDst']) : null,
            'createEmpty' => isset($this->options['createEmpty']) && !$this->options['createEmpty'] ?
                new Type($this->options['createEmpty']) : null,
        ]));
        return '|> aggregateWindow(' . $input . ') ';
    }
}
