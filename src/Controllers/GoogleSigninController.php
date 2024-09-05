<?php

namespace Motomedialab\GoogleSignin\Controllers;

use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;
use Motomedialab\GoogleSignin\Contracts\AuthenticatesUser;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;

class GoogleSigninController
{
    /**
     * @return RedirectResponse|SymfonyRedirectResponse
     */
    public function index()
    {
        return Socialite::driver('google-signin')->redirect();
    }

    public function store(AuthenticatesUser $authenticate)
    {
        try {
            // get our socialite user
            $socialiteUser = Socialite::driver('google-signin')->user();
        } catch (\Throwable $e) {
            abort(403, __('Failed to authenticate with Google'));
        }

        // create a query instance
        $builder = config('google-signin.user_model')::query();

        // attempt to find our user by google_id
        if ($user = $builder->clone()->firstWhere('google_id', $socialiteUser->getId())) {
            return $authenticate($user);
        }

        // attempt to find our user by email and set their google_id
        if ($user = $builder->whereNull('google_id')->firstWhere('email', $socialiteUser->getEmail())) {
            $user->forceFill(['google_id' => $socialiteUser->getId()])->save();

            return $authenticate($user);
        }

        abort(403, __('Failed to authenticate with Google'));
    }
}
