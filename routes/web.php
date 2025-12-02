<?php

/**
 * Greenhouse
 * —————————————————————————————————————————————————————————————————————————————
 * Clementine Technology Solutions LLC. (dba. Clementine Solutions).
 * @author      Steven "Chris" Clements <clements.steven07@outlook.com>
 * @version     1.0.0
 * @since       1.0.0
 * @copyright   © 2025-2026 Clementine Solutions. All Rights Reserved.
 */

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MfaController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\LoginThrottle;
use Illuminate\Support\Facades\Route;

/* —————————————————————————————————————————————————————————————————————————— *\
| Public routes                                                                |
\* —————————————————————————————————————————————————————————————————————————— */


/* —————————————————————————————————————————————————————————————————————————— *\
| Verification routes                                                          |
\* —————————————————————————————————————————————————————————————————————————— */
/**
 * These routes leverage Laravel's built-in system for email verifcation.
 * Do not update these routes without reading the documentation!
 * @see https://laravel.com/docs/12.x/verification
 */
Route::get('/email/verify', [AuthController::class, 'notice'])
    ->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verify'])
    ->middleware(['signed'])
    ->name('verification.verify');


/* —————————————————————————————————————————————————————————————————————————— *\
| Authentication routes                                                        |
\* —————————————————————————————————————————————————————————————————————————— */
Route::get('/login', [AuthController::class, 'create'])->name('login');
Route::post('/auth/login', [AuthController::class, 'store'])
    ->middleware(LoginThrottle::class);


/* —————————————————————————————————————————————————————————————————————————— *\
| Multi-factor routes                                                          |
\* —————————————————————————————————————————————————————————————————————————— */
Route::get('/multi-factor', [MfaController::class, 'index']);
Route::post('/multi-factor/send-sms', [MfaController::class, 'sendSms']);
Route::get('/multi-factor/setup/sms', [MfaController::class, 'setupSms']);
Route::get('/multi-factor/setup/totp', [MfaController::class, 'setupTotp']);
Route::get('/multi-factor/verify/sms', [MfaController:: class, 'renderSms']);
Route::post('/multi-factor/verify/sms', [MfaController::class, 'verifySms']);
Route::post('/multi-factor/verify/totp', [MfaController::class, 'verifyTotp']);


/* —————————————————————————————————————————————————————————————————————————— *\
| User resource                                                                |
\* —————————————————————————————————————————————————————————————————————————— */
Route::get('/register', [UserController::class, 'create']);
Route::post('/users', [UserController::class, 'store']);


/* —————————————————————————————————————————————————————————————————————————— *\
| Account resource                                                             |
\* —————————————————————————————————————————————————————————————————————————— */
Route::get('/dashboard', function () {
    return view('dashboard');
});
