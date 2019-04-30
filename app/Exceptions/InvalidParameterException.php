<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Collection;

class InvalidParameterException extends Exception
{
    /**
     * Invalid parameters static constructor.
     *
     * @param array|Collection $parameters
     * @return static
     */
    public static function parameters($parameters)
    {
        $parameters = Collection::make($parameters);

        return new static('Invalid 2fa validation parameters: "' . $parameters->implode(',') . '".');
    }
}
