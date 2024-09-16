<?php

namespace Motomedialab\GoogleSignin\Controllers;

use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Motomedialab\GoogleSignin\Contracts\AuthenticatesUser;
use Motomedialab\GoogleSignin\Contracts\DeniesAccess;
use Motomedialab\GoogleSignin\Enums\DenialReason;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class GoogleSigninController
{
    public function index(): SymfonyRedirectResponse|RedirectResponse
    {
        return Socialite::driver('google-signin')->redirect();
    }

    public function store(AuthenticatesUser $authenticate, DeniesAccess $deny): mixed
    {
        try {
            // get our socialite user
            $socialiteUser = Socialite::driver('google-signin')->user();
        } catch (\Throwable $e) {
            return $deny(DenialReason::InvalidState);
        }

        // create a query instance from our model
        $builder = config('google-signin.user_model')::query();

        // attempt to find our user by google_id
        if ($user = $builder->clone()->firstWhere('google_id', $socialiteUser->getId())) {
            return $authenticate($user);
        }

        // check if our email has a pre-existing Google ID (possible email hijacking)
        if ($builder->clone()->whereNotNull('google_id')->where('email', $socialiteUser->getEmail())->exists()) {
            return $deny(DenialReason::GoogleIdMismatch);
        }

        // attempt to find our user by email and set their google_id
        if ($user = $builder->firstWhere('email', $socialiteUser->getEmail())) {
            $response = $authenticate($user);
            
            $user->forceFill(['google_id' => $socialiteUser->getId()])->save();
            
            return $response;
        }

        return $deny(DenialReason::EmailNotFound);
    }
}
