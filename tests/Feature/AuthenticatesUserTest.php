<?php

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Motomedialab\GoogleSignin\Contracts\AuthenticatesUser;
use Motomedialab\GoogleSignin\Tests\Stubs\TestUser;

beforeEach(fn() => $this->loadMigrationsFrom(__DIR__.'/../migrations'));

it('will authenticate a user', function () {

    Config::set('google-signin.user_model', TestUser::class);

    $user = tap((new TestUser())->forceFill([
        'name' => 'Test User',
        'email' => 'test@example.com',
    ]))->save();

    $response = App::call(AuthenticatesUser::class, ['model' => $user]);

    expect($response)->toBeInstanceOf(RedirectResponse::class);

    $this->assertAuthenticatedAs($user);
});
