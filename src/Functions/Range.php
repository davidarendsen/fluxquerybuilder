<?php

namespace Arendsen\FluxQueryBuilder\Functions;

use Arendsen\FluxQueryBuilder\Exception\FunctionRequiredSettingMissingException;
use Arendsen\FluxQueryBuilder\Type;
use DateTime;

class Range extends Base
{
    /**
     * @var mixed $start
     */
    private $start;

    /**
     * @var mixed $stop
     */
    private $stop;

    public function __construct(DateTime $start, ?DateTime $stop = null)
    {
        $this->start = new Type($start);
        $this->stop = $stop ?  new Type($stop) : null;
    }

    public function __toString()
    {
        if (!$this->start) {
            throw new FunctionRequiredSettingMissingException('Range', 'Start setting is required!');
        }

        $settingsString = 'start: ' . $this->start;
        if ($this->stop) {
            $settingsString .= ', stop: ' . $this->stop;
        }

        return '|> range(' . $settingsString . ') ';
    }
}
