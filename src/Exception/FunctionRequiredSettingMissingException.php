<?php

namespace Arendsen\FluxQueryBuilder\Exception;

use Exception;

class FunctionRequiredSettingMissingException extends Exception {
    
    public function __construct(string $functionName, string $message)
    {
        parent::__construct('Function ' . $functionName . ' - ' . $message);
    }

}