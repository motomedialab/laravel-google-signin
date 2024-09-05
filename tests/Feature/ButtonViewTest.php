<?php

use Illuminate\Support\Facades\Blade;

it('can render the button view', function () {

    $rendered = Blade::render("<x-google-signin::button />");

    expect($rendered)->toContain('Sign in with Google');
});
