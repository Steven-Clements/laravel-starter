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
use Illuminate\View\View;
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
    public function verify($id, $hash): RedirectResponse
    {
        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Invalid verification link.');
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

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
    public function store(): RedirectResponse
    {
        /* —— ⦿ —— ⦿ —— ⦿ —— { Redirect to dashboard } —— ⦿ —— ⦿ —— ⦿ —— */
        return redirect('/accounts/dashboard');
    }
}
