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
        $subArray = isset($this->settings['subArray']) && $this->settings['subArray'];

        array_walk($this->value, function (&$value, $key) {
            if (is_string($key)) {
                $value = $key . ': ' . new Type($value, [
                    'subArray' => is_array($value)
                ]);
            } else {
                $value = new Type($value, [
                    'subArray' => is_array($value)
                ]);
            }
        });

        return ($subArray ? '[' : '') . implode(', ', $this->value) . ($subArray ? ']' : '');
    }
}
