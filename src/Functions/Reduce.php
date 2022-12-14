<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Type\RecordType;

class Reduce extends Base
{
    /**
     * @var array $settings
     */
    private $settings;

    /**
     * @var array $identity
     */
    private $identity;

    public function __construct(array $settings, array $identity)
    {
        $this->settings = $settings;
        $this->identity = $identity;
    }

    public function __toString()
    {
        return '|> reduce(fn: (r, accumulator) => (' . new RecordType($this->settings) . '), ' .
            'identity: ' . new RecordType($this->identity) . ') ';
    }
}
