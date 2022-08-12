<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Exception\FunctionRequiredSettingMissingException;
use Arendsen\FluxQueryBuilder\Formatters;
use DateTime;

class Range extends Base {

    /**
     * @var mixed $start
     */
    private $start;

    /**
     * @var mixed $stop
     */
    private $stop;

    public function __construct(array $settings)
    {
        $this->start = isset($settings['start']) ? $settings['start'] : null;
        $this->stop = isset($settings['stop']) ? $settings['stop'] : null;
    }

    public function __toString()
    {
        if(!$this->start)
        {
            throw new FunctionRequiredSettingMissingException('Range', 'Start setting is required!');
        }

        if($this->start instanceof DateTime)
        {
            $this->start = Formatters::dateTimeToString($this->start);
        }

        if($this->stop instanceof DateTime)
        {
            $this->stop = Formatters::dateTimeToString($this->stop);
        }

        $settingsString = 'start: ' . $this->start;
        if($this->stop)
        {
            $settingsString .= ', stop: ' . $this->stop;
        }

        return '|> range(' . $settingsString . ') ';
    }

}