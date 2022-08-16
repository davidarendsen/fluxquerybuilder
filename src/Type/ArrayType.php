<?php

namespace Arendsen\FluxQueryBuilder\Type;

use Arendsen\FluxQueryBuilder\Type;

class ArrayType implements TypeInterface
{
    /**
     * @var array $value
     */
    protected $value;

    /**
     * @var array $settings
     */
    protected $settings;

    public function __construct(array $value, $settings = [])
    {
        $this->value = $value;
        $this->settings = $settings;
    }

    public function __toString(): string
    {
        if (isset($this->settings['isRecord']) && $this->settings['isRecord']) {
            return new RecordType($this->value);
        }

        $subArray = isset($this->settings['isNestedArray']) && $this->settings['isNestedArray'];

        array_walk($this->value, function (&$value, $key) {
            if (is_string($key)) {
                $value = $key . ': ' . new Type($value, [
                    'isNestedArray' => is_array($value)
                ]);
            } else {
                $value = new Type($value, [
                    'isNestedArray' => is_array($value)
                ]);
            }
        });

        return ($subArray ? '[' : '') . implode(', ', $this->value) . ($subArray ? ']' : '');
    }
}
