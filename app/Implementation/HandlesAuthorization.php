<?php

namespace App\Implementation;

use Flugg\Responder\Exceptions\Http\UnauthorizedException;
use Illuminate\Auth\Access\HandlesAuthorization as DefaultHandler;

/**
 * This trait can be used to modify unautorized response so that it can
 * accept messages that can be shown to the requesting user.
 * It is can used in policies and controller methods.
 */
trait HandlesAuthorization
{
    use DefaultHandler;

    /**
     * Throws an unauthorized exception.
     *
     * @param  string  $message
     * @return void
     *
     * @throws Flugg\Responder\Exceptions\Http\UnauthorizedException
     */
    protected function deny($message = 'This action is unauthorized.')
    {
        throw new UnauthorizedException($message);
    }
}
