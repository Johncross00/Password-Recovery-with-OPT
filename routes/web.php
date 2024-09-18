<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';


Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/forgot-password', function () {
    return view('auth.forgot_pswd');
})->name('forgot_password');

Route::get('/reset-password', function () {
    return view('auth.reset_pswd');
})->name('reset_password');

Route::get('/prime-numbers', function () {
    return view('prime_numbers');
})->name('prime_numbers');
