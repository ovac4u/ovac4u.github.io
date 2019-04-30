<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService
{
    public function findOrCreate(ProviderUser $providerUser, $provider)
    {
        $account = LinkedSocialAccount::where('provider_name', $provider)
            ->where('provider_id', $providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {
            $user = User::where('email', $providerUser->getEmail())->first();

            if (!$user) {
                $fullName = $this->getFirstLastNames($providerUser->getName());

                $user = User::create(array_merge(['email' => $providerUser->getEmail()], $fullName));
            }

            $user->accounts()->create([
                'provider_id' => $providerUser->getId(),
                'provider_name' => $provider,
            ]);

            return $user;
        }
    }

    protected function getFirstLastNames($fullName)
    {
        $parts = array_values(array_filter(explode(" ", $fullName)));

        $size = count($parts);

        if (empty($parts)) {
            $result['first_name'] = null;
            $result['last_name'] = null;
        }

        if (!empty($parts) && $size == 1) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = null;
        }

        if (!empty($parts) && $size >= 2) {
            $result['first_name'] = $parts[0];
            $result['last_name'] = $parts[1];
        }

        return $result;
    }
}
