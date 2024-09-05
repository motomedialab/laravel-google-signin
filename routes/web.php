<?php

use Illuminate\Support\Facades\Route;
use Motomedialab\GoogleSignin\Controllers\GoogleSigninController;

Route::group(['middleware' => config('google-signin.middleware')], function () {
    Route::get(config('google-signin.redirect_path'), [GoogleSigninController::class, 'index'])->name('google-signin.index');

    Route::get(config('google-signin.callback_path'), [GoogleSigninController::class, 'store'])->name('google-signin.store');
});
