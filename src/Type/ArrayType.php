<?php

namespace Arendsen\FluxQueryBuilder\Type;

use Arendsen\FluxQueryBuilder\Settings;
use Arendsen\FluxQueryBuilder\Type;

class ArrayType implements TypeInterface
{
    public const SETTING_IS_NESTED_ARRAY = 'isNestedArray';

    /**
     * @var array $value
     */
    protected $value;

    /**
     * @var Settings|null $settings
     */
    protected $settings;

    public function __construct(array $value, Settings $settings = null)
    {
        $this->value = $value;
        $this->settings = $settings ? $settings : Settings::set([]);
    }

    public function __toString(): string
    {
        if ($this->settings->get(RecordType::SETTING_IS_RECORD)) {
            return new RecordType($this->value);
        }

        array_walk($this->value, function (&$value, $key) {
            if ($this->isAssociativeArray($key)) {
                $value = $key . ': ' . new Type($value, Settings::set([
                    self::SETTING_IS_NESTED_ARRAY => is_array($value)
                ]));
            } else {
                $value = new Type($value, Settings::set([
                    self::SETTING_IS_NESTED_ARRAY => is_array($value)
                ]));
            }
        });

        return $this->getPrefix() . implode(', ', $this->value) . $this->getSuffix();
    }

    protected function isAssociativeArray($key): bool
    {
        return is_string($key);
    }

    protected function isNestedArray(): bool
    {
        return $this->settings->get(self::SETTING_IS_NESTED_ARRAY) ? true : false;
    }

    protected function getPrefix(): string
    {
        return $this->isNestedArray() ? '[' : '';
    }

    protected function getSuffix(): string
    {
        return $this->isNestedArray() ? ']' : '';
    }
}
