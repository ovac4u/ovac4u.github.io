<?php

if (!function_exists('validatePhone')) {
    /**
     * Check if a phone number is a valid international phone number.
     *
     * @param  string         The phone number to validate.
     * @param  string         The country to validate the phone number againt.
     * @return boolean
     */
    function validatePhone(string $phone, string $country = null): bool
    {
        try {
            $phoneNumberUtil = \libphonenumber\PhoneNumberUtil::getInstance();

            return $phoneNumberUtil->isValidNumber($phoneNumberUtil->parse($phone, $country));
        } catch (\Exception $e) {
            return false;
        }
    }
}
