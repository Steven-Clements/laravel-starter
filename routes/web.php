<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

Route::get('/notice', function () {
    return view('notice');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
