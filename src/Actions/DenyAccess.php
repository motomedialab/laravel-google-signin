<?php

namespace Motomedialab\GoogleSignin\Actions;

use Motomedialab\GoogleSignin\Contracts\DeniesAccess;
use Motomedialab\GoogleSignin\Enums\DenialReason;

class DenyAccess implements DeniesAccess
{
    public function __invoke(DenialReason $reason): mixed
    {
        abort($reason->getStatusCode(), $reason->getDescription());
    }
}
