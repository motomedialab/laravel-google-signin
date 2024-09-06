<?php

namespace Motomedialab\GoogleSignin\Contracts;

use Motomedialab\GoogleSignin\Enums\DenialReason;

interface DeniesAccess
{
    public function __invoke(DenialReason $reason): mixed;
}
