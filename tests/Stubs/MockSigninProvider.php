<?php

namespace Motomedialab\GoogleSignin\Tests\Stubs;

use Laravel\Socialite\Two\User;

class MockSigninProvider
{
    public function user(): User
    {
        return (new User())->map([
            'id' => 'mock-id',
            'nickname' => 'mocked-user',
            'name' => 'Mock User',
            'email' => 'mockuser@example.com',
            'avatar' => null,
            'avatar_original' => null,
        ]);
    }
}
