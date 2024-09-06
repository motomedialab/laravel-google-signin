<?php

namespace Motomedialab\GoogleSignin\Attributes;

use Attribute;

#[Attribute]
class ErrorDetails
{
    public function __construct(public string $description, public int $status = 403)
    {
        //
    }
}
