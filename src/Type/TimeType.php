<?php

namespace Arendsen\FluxQueryBuilder\Type;

use DateTime;

class TimeType implements TypeInterface
{
    public function __construct(DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }

    public function __toString(): string
    {
        return 'time(v: ' . $this->dateTime->format('Y-m-d\TH:i:s\Z') . ')';
    }
}
