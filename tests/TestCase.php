<?php

namespace Motomedialab\GoogleSignin\Tests;

use Laravel\Socialite\SocialiteServiceProvider;
use Motomedialab\GoogleSignin\GoogleSigninServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{

    protected function getPackageProviders($app): array
    {
        return [
            SocialiteServiceProvider::class,
            GoogleSigninServiceProvider::class,
        ];
    }
}
