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
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * User Controller
 * —————————————————————————————————————————————————————————————————————————————
 * Defines create, read, update, and delete (CRUD) functionality for the User
 * resource.
 */
class UserController extends Controller
{
    /**
     * @function create  | Public
     * —————————————————————————————————————————————————————————————————————————
     * Allow users to register with self-asserted data.
     * @return View
     * The Blade view to load.
     */
    public function create(): View
    {
        /* —— ⦿ —— ⦿ —— ⦿ —— { Render register form } —— ⦿ —— ⦿ —— ⦿ —— */
        return view('users.register');
    }


    /**
     * @function store  | Public
     * —————————————————————————————————————————————————————————————————————————
     * Registers a new user and sends a verification link by email.
     * @param Request $request
     * Data and parameters from the incoming HTTP request.
     * @return void
     */
    public function store(Request $request): RedirectResponse
    {
        /* —— ⦿ —— ⦿ —— ⦿ —— { Validate request } —— ⦿ —— ⦿ —— ⦿ —— */
        $validatedData = $request->validate([
            'name' => ['required', 'min:3', 'max:50', 'regex:/^[\p{L}\s\'-]+$/u'],
            'username' => ['required', 'min:3', 'max:25', 'regex:/^[\p{L}\p{N}_-]+$/u'],
            'email' => ['required', 'email', 'min:6', 'max:254'],
            'password' => ['required', 'min:8', 'max:64', 'confirmed'],
            'password_confirmation' => ['required']
        ]);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Search for user } —— ⦿ —— ⦿ —— ⦿ —— */
        $userExists = User::where('email', $validatedData['email'])->first();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Check if user exists } —— ⦿ —— ⦿ —— ⦿ —— */
        if ($userExists) {
            abort(409, 'Email address is already in use.');
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Register user } —— ⦿ —— ⦿ —— ⦿ —— */
        $user = User::create([
            'name' => $validatedData['name'],
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => $validatedData['password']
        ]);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Check for user } —— ⦿ —— ⦿ —— ⦿ —— */
        if (!$user) {
            abort(500, 'An unexpected error occurred during registration. Please try again later.');
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Fire registered event } —— ⦿ —— ⦿ —— ⦿ —— */
        event(new Registered($user));


        /* —— ⦿ —— ⦿ —— ⦿ —— { Redirect to notice } —— ⦿ —— ⦿ —— ⦿ —— */
        return redirect('/email/verify');
    }
}
