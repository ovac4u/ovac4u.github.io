<?php

namespace App\Http\Controllers\UserApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\ChangePasswordRequest;
use App\Http\Requests\Settings\UpdateProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @group Account Settings
 */
class SettingController extends Controller
{
    /**
     * Update profile
     *
     * Update the authenticated user's profile.
     *
     * @bodyParam first_name string
     * Updates the user's first name. Example: John
     *
     * @bodyParam last_name string
     * Updates the user's last name. Example: Mahama
     *
     * @bodyParam other_names string
     * Updates the user's other names. Example: Ibhrahim
     *
     * @bodyParam email string
     * Updates the user's email address (must be unique). Example: iamovac@gmail.com
     *
     * @bodyParam username string
     * Updates the user's username (must be unique). Example: ovac
     *
     * @authenticated
     * @responseFile responses/v1/settings.update.profile.json
     *
     * @param  \Illuminate\Http\UpdateProfileRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $this->user->update($request->validated());

        return responder()->success($this->user)

            ->meta(['message' => __('messages.settings.profile_updated')]);
    }

    /**
     * Change password
     *
     * Change the password on the authenticated user's account
     *
     * @bodyParam current_password string required
     * The current password. Example: secret
     *
     * @bodyParam password string required
     * The new password. Example: P@$$word
     *
     * @bodyParam password_confirmation string required
     * The new password confirmation. Example: P@$$word
     *
     * @authenticated
     * @responseFile responses/v1/settings.change.password.json
     *
     * @param  \Illuminate\Http\ChangePasswordRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $this->user->password = Hash::make($request->input('password'));

        $this->user->setRememberToken(Str::random(60));

        $this->user->save();

        return responder()->success()

            ->meta(['message' => __('messages.settings.password_changed')]);
    }
}
