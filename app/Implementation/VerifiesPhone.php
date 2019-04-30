<?php

namespace App\Implementation;

use App\Notifications\PhoneVerificationRequest;
use App\User;
use App\UserPhone;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * Handles all concerns related to verifying a phone number.
 */
trait VerifiesPhone
{
    /**
     * Send verification code to a given user's phone number.
     *
     * @param  User    $user     Ther user that provided the phone number.
     * @param  array   $values   An array containing the phone number and country
     * @return string
     */
    public static function requestPhoneVerification(User $user, array $values): string
    {
        //Generate a 4 digit code and a hashed
        //version of the same 4 digit code.
        $token = Hash::make($code = rand(1000, 9999));

        //Send the 4 digit code to the provided phone number
        $user->notify(new PhoneVerificationRequest($code, $values['phone']));

        //Save the verification code the in cache for a number of seconds.
        //The cache will expire after the given number of seconds.
        //When this data expires, the user will need  to go
        //through the process again.
        cache([static::phoneCacheKey($user->id, $values['phone']) => $token], config('navigateme.phone.code_ttl'));

        return __('messages.user_phone.code_sent', array_only($values, 'phone'));
    }

    /**
     * Send verification code to a given user's phone number.
     *
     * @param  User    $user     Ther user that provided the phone number.
     * @param  array   $values   An array containing the phone number and country
     * @return UserPhone         The user's verified phone record.
     * @throws ValidationException
     */
    public static function attemptVerification(User $user, array $values): UserPhone
    {
        //Check if the cache exists and retrieve the token from the cache memory.
        if (!$token = cache(static::phoneCacheKey($user->id, $values['phone']))) {
            throw ValidationException::withMessages(['code' => 'validation.user_phone.code_expired']);
        }

        //, and if the harsh of the provided code matches
        //the hash in the cache. If so, then we can store and verify the phone.
        if (!Hash::check($values['code'], $token)) {
            throw ValidationException::withMessages(['code' => __('validation.user_phone.invalid_code')]);
        }

        //Make the UserPhone model with the given phone and country.
        $userPhone = UserPhone::make($values);

        //Mark the user's phonennumber as verified then
        //associate it with the given user and save it.
        $userPhone->verified_at = now();
        $user->phones()->save($userPhone);

        return $userPhone;
    }

    /**
     * Reteieve the unique cache key for the user's phone number
     *
     * @param  integer   $userId
     * @param  string $phoneNumber
     * @return string
     */
    public static function phoneCacheKey(int $userId, string $phoneNumber)
    {
        return __METHOD__ . "({$userId}, {$phoneNumber})";
    }
}
