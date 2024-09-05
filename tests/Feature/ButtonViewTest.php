<?php

it('can render the button view', function () {

    $rendered = view('google-signin::button')->render();

    expect($rendered)->toContain('Sign in with Google');
});
