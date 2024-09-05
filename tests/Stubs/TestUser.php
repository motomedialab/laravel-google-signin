<?php

namespace Motomedialab\GoogleSignin\Tests\Stubs;

use Illuminate\Foundation\Auth\User as Authenticatable;

class TestUser extends Authenticatable
{
    protected $table = 'test_users';
}
