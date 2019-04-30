<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Phone number verification configurations
    |--------------------------------------------------------------------------
     */
    'phone' => [
        //The amount of time allowed for a user to complete
        //the phone number verification process in seconds.
        //
        //Defaults to 300s (5 mins)
        'code_ttl' => env('PHONE_VERIFICATION_CODE_TTL', 300),

        // The amout of time allowed for a user's generated 2fa code to live.
        // Not to be confused with the Google 2FA -- this is an alternative
        // code that a user may use instead  of the google 2fa code.
        //
        // This is generated using the user's USSD
        //Defaults to 300s (5 mins)
        'user_2fa_ttl' => env('USER_GENERATED_2FA_TTL', 300),
    ],
];
