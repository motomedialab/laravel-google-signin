<?php

return [
    /**
     * The middleware that should be applied to the authentication routes.
     */
    'middleware' => ['web', 'guest'],

    /**
     * The guard that should be used to authenticate the user.
     */
    'auth_guard' => env('GOOGLE_OAUTH_AUTH_GUARD', config('auth.defaults.guard')),

    /**
     * The authentication path to the socialite controller.
     * This should only be changed if it conflicts with an existing route.
     */
    'redirect_path' => '/auth/google/redirect',

    /**
     * The callback path to the socialite controller.
     * This should only be changed if it conflicts with an existing route.
     */
    'callback_path' => '/auth/google/callback',

    /**
     * The authentication method that should be used to authenticate the user.
     * This should be a class that implements the Motomedialab\GoogleSignin\Contracts\AuthenticatesUser contract.
     */
    'authentication_method' => Motomedialab\GoogleSignin\Actions\AuthenticateUser::class,

    /**
     * The Google client ID for the oAuth consent screen.
     */
    'client_id' => env('GOOGLE_OAUTH_CLIENT_ID'),

    /**
     * The Google client secret for the oAuth consent screen.
     */
    'client_secret' => env('GOOGLE_OAUTH_CLIENT_SECRET'),

    /**
     * The user model that should be used for authentication.
     * This MUST implement Laravel's Authenticatable contract.
     */
    'user_model' => \App\Models\User::class,
];
