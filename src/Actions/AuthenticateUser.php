<?php

namespace Motomedialab\GoogleSignin\Actions;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;
use Motomedialab\GoogleSignin\Contracts\AuthenticatesUser;

class AuthenticateUser implements AuthenticatesUser
{
    public function __invoke(Authenticatable $model): RedirectResponse
    {
        auth(config('google-signin.auth_guard', 'web'))->login($model, true);

        return redirect()->intended();
    }
}
