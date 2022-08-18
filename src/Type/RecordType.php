<?php

namespace Arendsen\FluxQueryBuilder\Type;

use Arendsen\FluxQueryBuilder\Settings;
use Arendsen\FluxQueryBuilder\Type;

class RecordType implements TypeInterface
{
    public const SETTING_IS_RECORD = 'isRecord';

    public function __construct(array $value)
    {
        $this->value = $value;
    }

    public function __toString(): string
    {
        array_walk($this->value, function (&$value, $key) {
            if (is_string($key)) {
                $value = $key . ': ' . new Type($value, Settings::set([
                    self::SETTING_IS_RECORD => true,
                ]));
            } else {
                $value = new Type($value, Settings::set([
                    self::SETTING_IS_RECORD => true,
                ]));
            }
        });

        return '{' . implode(', ', $this->value) . '}';
    }
}
