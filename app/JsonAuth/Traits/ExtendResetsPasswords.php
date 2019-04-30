<?php

namespace App\JsonAuth\Traits;

use Illuminate\Foundation\Auth\ResetsPasswords;

trait ExtendResetsPasswords
{
    use ResetsPasswords {
        ResetsPasswords::reset as parentReset;
        ResetsPasswords::showResetForm as parentShowResetForm;
        ResetsPasswords::sendResetResponse as parentSendResetResponse;
        ResetsPasswords::sendResetFailedResponse as parentSendResetFailedResponse;
    }
}
