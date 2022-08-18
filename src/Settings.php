<?php

namespace Arendsen\FluxQueryBuilder;

class Settings
{
    /**
     * @var array $settings
     */
    protected $settings;

    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    public static function set(array $settings = [])
    {
        return new self($settings);
    }

    public function get(string $key)
    {
        return isset($this->settings[$key]) ? $this->settings[$key] : null;
    }
}
