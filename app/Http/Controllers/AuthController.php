<?php

/**
 * Clementine Solutions
 * —————————————————————————————————————————————————————————————————————————————
 * Clementine Technology Solutions LLC. (dba. Clementine Solutions).
 * @author      Steven "Chris" Clements <clements.steven07@outlook.com>
 * @version     1.0.0
 * @since       1.0.0
 * @copyright   © 2025-2026 Clementine Solutions. All Rights Reserved.
 */

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Mockery\Undefined;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Auth Controller
 * —————————————————————————————————————————————————————————————————————————————
 * Defines create, read, update, and delete (CRUD) functionality authentication
 * and verification.
 */
class AuthController extends Controller
{
    /**
     * @function notice  | Public
     * —————————————————————————————————————————————————————————————————————————
     * Informs users when registration is successful and advises them to verify
     * their email address.
     * @return View
     * The Blade view to load.
     */
    public function notice(): View
    {
        /* —— ⦿ —— ⦿ —— ⦿ —— { Render verification notice } —— ⦿ —— ⦿ —— ⦿ —— */
        return view('verification.notice');
    }


    /**
     * @function verify  | Public
     * —————————————————————————————————————————————————————————————————————————
     * Verifies a user's email address.
     * @param string $id
     * The unique ID corresponding to the user.
     * @param string $hash
     * The asserted verification token.
     * @return void
     */
    public function verify(string $id, string $hash, Request $request): RedirectResponse
    {
        /* —— ⦿ —— ⦿ —— ⦿ —— { Search database for user } —— ⦿ —— ⦿ —— ⦿ —— */
        $user = User::findOrFail($id);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Verify token submission } —— ⦿ —— ⦿ —— ⦿ —— */
        if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Render login form } —— ⦿ —— ⦿ —— ⦿ —— */
        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Redirect to login } —— ⦿ —— ⦿ —— ⦿ —— */
        return redirect('/login')->with('status', 'Email verified!');
    }


    /**
     * @function create  | Public
     * —————————————————————————————————————————————————————————————————————————
     * Allow users to attempt to sign in with self-asserted data.
     * @return View
     * The Blade view to load.
     */
    public function create(): View
    {
        /* —— ⦿ —— ⦿ —— ⦿ —— { Render login form } —— ⦿ —— ⦿ —— ⦿ —— */
        return view('auth.login');
    }


    /**
     * @function store  | Public
     * —————————————————————————————————————————————————————————————————————————
     * Authenticate a user with basic authentication.
     * @param Request $request
     * Data and parameters from the incoming HTTP request.
     * @return void
     */
    public function store(Request $request): RedirectResponse
    {
        /* —— ⦿ —— ⦿ —— ⦿ —— { Helper variables } —— ⦿ —— ⦿ —— ⦿ —— */
        $method = 'email';


        /* —— ⦿ —— ⦿ —— ⦿ —— { Validate request } —— ⦿ —— ⦿ —— ⦿ —— */
        $validatedData = $request->validate([
            'emailOrUsername' => ['required'],
            'password' => ['required', 'min:8']
        ]);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Search database for user } —— ⦿ —— ⦿ —— ⦿ —— */
        $user = User::where('email', $validatedData['emailOrUsername'])
            ->orWhere('username', $validatedData['emailOrUsername'])
            ->first();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Check if user exists } —— ⦿ —— ⦿ —— ⦿ —— */
        if (!$user) {
            abort(401, 'Invalid email address or password');
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Account for no email } —— ⦿ —— ⦿ —— ⦿ —— */
        if (!$user->email) {
            $method = 'username';
        } else {
            /* —— ⦿ —— ⦿ —— ⦿ —— { Check if email verified } —— ⦿ —— ⦿ —— ⦿ —— */
            if (!$user->hasVerifiedEmail()) {
                abort(403, 'Please verify your email address before logging in.');
            }
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Verify password entry } —— ⦿ —— ⦿ —— ⦿ —— */
        if (!Auth::validate([
            $method => $validatedData['emailOrUsername'],
            'password' => $validatedData['password'],
            'status' => 'active'
        ])) {
            abort(401, 'Invalid email address or password.');
        }


        if ($user->is_mfa_enabled) {
            dd('multi-factor required...');
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Start new session } —— ⦿ —— ⦿ —— ⦿ —— */
        Auth::login($user);
        $request->session()->regenerate();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Update user login data } —— ⦿ —— ⦿ —— ⦿ —— */
        $user->last_login_ip = $request->ip();
        $user->last_login_at = now();
        $user->save();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Redirect to dashboard } —— ⦿ —— ⦿ —— ⦿ —— */
        return redirect('/accounts/dashboard');
    }
}
