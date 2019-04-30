<?php

namespace App\Http\Controllers\UserApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPhone\VerificationCodeRequest;
use App\Http\Requests\UserPhone\VerifyPhoneRequest;
use App\UserPhone;
use Illuminate\Http\Request;

/**
 * @group User Phone
 */
class UserPhoneController extends Controller
{

    /**
     * Restrict the controller api methods.
     */
    public function __construct()
    {
        parent::__construct();

        $this->authorizeResource(UserPhone::class, 'phone');
    }

    /**
     * List verified numbers
     *
     * Query for the list of verified phone number for the authenticated user.
     *
     * @authenticated
     * @responseFile responses/v1/phones.index.json
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return responder()->success($this->user->phones);
    }

    /**
     * Send verification code
     *
     * Add and send verification code to a given phone number.
     *
     * @bodyParam country string required
     * A valid ISO 3166-1 alpha-2 country code. Example: gh
     *
     * @bodyParam phone string required
     * A valid phone number for the given country. Example: +233553577261
     *
     * @authenticated
     * @responseFile responses/v1/phones.store.json
     *
     * @param  \Illuminate\Http\VerificationCodeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VerificationCodeRequest $request)
    {
        $message = UserPhone::requestPhoneVerification($this->user, $request->validated());

        return responder()->success()

            ->meta(['message' => $message]);
    }

    /**
     * Get phone
     *
     * Get a verified phone number by it's unique ID.
     *
     * @pathParam phone integer required
     * The ID of the phone number to retrieve. Example: 1
     *
     * @authenticated
     * @responseFile responses/v1/phones.show.json
     *
     * @param  \App\UserPhone  $phone
     * @return \Illuminate\Http\Response
     */
    public function show(UserPhone $phone)
    {
        return responder()->success($phone);
    }

    /**
     * Verify phone.
     *
     * Verify a phone number with a code that was sent via text/SMS.
     *
     * @bodyParam country string required
     * A valid ISO 3166-1 alpha-2 country code. Example: gh
     *
     * @bodyParam phone string required
     * A valid phone number for the given country. Example: +233553577261
     *
     * @bodyParam code integer required
     * The verification code that was sent to the given phone number. Example: 1234
     *
     * @authenticated
     * @responseFile responses/v1/phones.verify.json
     *
     * @param  \Illuminate\Http\VerifyPhoneRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function verify(VerifyPhoneRequest $request)
    {
        $phone = UserPhone::attemptVerification($this->user, $request->validated());

        return responder()->success($phone)

            ->meta(['message' => __('messages.user_phone.verified')]);
    }

    /**
     * Set default phone
     *
     * Set the given phone number ID as the default phone number.
     *
     * @pathParam phone integer required
     * The ID of the phone number to set as default. Example: 1
     *
     * @authenticated
     * @responseFile responses/v1/phones.setDefault.json
     *
     * @param  \App\UserPhone  $phone
     * @return \Illuminate\Http\Response
     */
    public function setDefault(UserPhone $phone)
    {
        $phone->setAsDefault();

        return responder()->success($phone)

            ->meta(['message' => __('messages.user_phone.defalt_updated', $phone->only('phone'))]);
    }

    /**
     * Delete phone
     *
     * Delete a verified phone number.
     *
     * @pathParam phone integer required
     * The ID of the phone number to remove. Example: 1
     *
     * @authenticated
     * @responseFile responses/v1/phones.delete.json
     *
     * @param  \App\UserPhone  $phone
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPhone $phone)
    {
        $phone->unsetAsDefault()->forceDelete();

        return responder()->success(array_except($phone, 'user'))

            ->meta(['message' => __('messages.user_phone.deleted')]);
    }

    /**
     * Get the map of resource methods to ability names.
     *
     * @return array
     */
    protected function resourceAbilityMap()
    {
        return [
            'show' => 'view',
            'setDefault' => 'view',
            'destroy' => 'view',
        ];
    }
}
