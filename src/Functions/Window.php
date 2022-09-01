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
     * @var array $options
     */
    private $options;

    public function __construct($every, array $options = []) {
        $this->every = $every;
        $this->options = $options;
    }

    public function __toString()
    {
        $input = new ArrayType(array_filter([
            'every' => new DurationType($this->every),
            'period' => isset($this->options['period']) ? new DurationType($this->options['period']) : null,
            'offset' => isset($this->options['offset']) ? new DurationType($this->options['offset']) : null,
            'location' => isset($this->options['location']) ? new Type($this->options['location']) : null,
            'timeColumn' => isset($this->options['timeColumn']) ? new Type($this->options['timeColumn']) : null,
            'startColumn' => isset($this->options['startColumn']) ? new Type($this->options['startColumn']) : null,
            'stopColumn' => isset($this->options['stopColumn']) ? new Type($this->options['stopColumn']) : null,
            'createEmpty' => isset($this->options['createEmpty']) && $this->options['createEmpty'] ? 
                new Type($this->options['createEmpty']) : null,
        ]));
        return '|> window(' . $input . ') ';
    }
}
