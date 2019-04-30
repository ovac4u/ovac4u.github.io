<?php

namespace App\JsonAuth\Traits;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

trait ExtendSendsPasswordResetEmails
{
    use SendsPasswordResetEmails {
        SendsPasswordResetEmails::sendResetLinkEmail as parentSendResetLinkEmail;
        SendsPasswordResetEmails::showLinkRequestForm as parentShowLinkRequestForm;
        SendsPasswordResetEmails::sendResetLinkResponse as parentSendResetLinkResponse;
        SendsPasswordResetEmails::sendResetLinkFailedResponse as parentSendResetLinkFailedResponse;
    }
}
