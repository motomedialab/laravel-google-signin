<?php

use Illuminate\Support\Facades\Config;
use Motomedialab\GoogleSignin\Tests\Stubs\MockSigninProvider;
use Motomedialab\GoogleSignin\Tests\Stubs\TestUser;

beforeEach(function () {
    Config::set('google-signin.client_id', 'TEST_CLIENT_ID');
    Config::set('google-signin.client_secret', 'TEST_CLIENT_SECRET');
    Config::set('google-signin.user_model', TestUser::class);

    $this->loadMigrationsFrom(__DIR__.'/../migrations');
});

it('throttles the amount of times the auth route is hit', function () {
    $route = route('google-signin.index');

    for ($i = 0; $i <= 3; $i++) {
        $response = $this->get($route);
    }

    expect($response->status())->toBe(429);
});

it('redirects away to google with required parameters', function () {
    $route = route('google-signin.index');

    $targetUrl = $this->get($route)
        ->assertRedirect()
        ->headers->get('Location');

    $parts = parse_url($targetUrl);

    expect($parts['host'])->toBe('accounts.google.com');

    parse_str($parts['query'], $result);

    expect($result)
        ->toBeArray()
        ->client_id->toBe('TEST_CLIENT_ID')
        ->redirect_uri->toBe(route('google-signin.store'));
});

it('will return 400 when state is invalid', function () {
    $this->get(route('google-signin.store'))->assertStatus(400);
});

it('will return 401 when no user is found', function () {
    Config::set('google-signin.provider', MockSigninProvider::class);

    $this->get(route('google-signin.store'))->assertStatus(401);
});

it('will return 403 when a google id is incorrect and email matches', function () {
    Config::set('google-signin.provider', MockSigninProvider::class);

    (new TestUser())->forceFill([
        'name' => 'Test User',
        'email' => 'mockuser@example.com', // make sure our email matches our mock user
        'google_id' => '123', // but our google ID is different...
    ])->save();

    $this->get(route('google-signin.store'))->assertStatus(403);
});

it('will authenticate user when google id matches', function () {
    Config::set('google-signin.provider', MockSigninProvider::class);

    $user = tap((new TestUser())->forceFill([
        'name' => 'Test User',
        'email' => 'oldemail@example.com', // make sure our email matches our mock user
        'google_id' => 'mock-id', // and our google ID is valid
    ]))->save();

    $this->get(route('google-signin.store'))->assertStatus(302);

    $this->assertAuthenticatedAs($user);
});

it('will authenticate and set google id when email matches without google id', function () {
    Config::set('google-signin.provider', MockSigninProvider::class);

    $user = tap((new TestUser())->forceFill([
        'name' => 'Test User',
        'email' => 'mockuser@example.com', // make sure our email matches our mock user
    ]))->save();

    $this->get(route('google-signin.store'))->assertStatus(302);

    $this->assertAuthenticatedAs($user);
});
