<?php

use Motomedialab\GoogleSignin\Enums\DenialReason;

it('can provide a description', function () {

    $reason = DenialReason::InvalidState;

    expect($reason->getDescription())
        ->toBeString()
        ->toEqual('The state parameter did not match the expected value.')
        ->and($reason->getStatusCode())->toBe(400);
});
