<?php

namespace Motomedialab\GoogleSignin\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\RedirectResponse;

interface AuthenticatesUser
{
    public function __invoke(Authenticatable $model): RedirectResponse;
}
