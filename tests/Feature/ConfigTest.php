<?php

it('can access the plugin configuration', function () {
    expect(config('google-signin'))
        ->toBeArray()
        ->toHaveKey('middleware');
});
