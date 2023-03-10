<?php

namespace Arendsen\FluxQueryBuilder\Type;

use Arendsen\FluxQueryBuilder\Settings;
use Arendsen\FluxQueryBuilder\Type;

class FieldRecordType implements TypeInterface
{
    public const SETTING_IS_RECORD = 'isRecord';

    /**
     * @var array $value
     */
    private $value;

    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        array_walk($this->value, function (&$value, $key) {
            if (is_string($key)) {
                $value = $key . ': ' . $value;
            }
        });

        return '{' . implode(', ', $this->value) . '}';
    }
}
