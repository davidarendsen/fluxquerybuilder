<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Exception\FunctionRequiredSettingMissingException;

class Range extends Base {

    /**
     * @var array $settings
     */
    private $settings;

    public function __construct(array $settings)
    {
        $this->settings = $settings;
    }

    public function __toString()
    {
        if(!isset($this->settings['start']))
        {
            throw new FunctionRequiredSettingMissingException('Range', 'Start setting is required!');
        }

        $settingsString = 'start: ' . $this->settings['start'];
        if(isset($this->settings['stop']))
        {
            $settingsString .= ', stop: ' . $this->settings['stop'];
        }

        return '|> range(' . $settingsString . ') ';
    }

}