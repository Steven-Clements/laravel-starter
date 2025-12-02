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

use App\Models\Secret;
use App\Models\User;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use PragmaRX\Google2FA\Google2FA;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Twilio\Rest\Client;

/**
 * Mfa Controller
 * —————————————————————————————————————————————————————————————————————————————
 * Defines create, read, update, and delete (CRUD) functionality for multi-
 * factor authentication operations.
 */
class MfaController extends Controller
{
    /**
     * @function index  | Public
     * —————————————————————————————————————————————————————————————————————————
     * Displays the multi-factor authentication methods the user can enroll in.
     * @return View
     * The Blade view to load.
     */
    public function index(): View
    {
        /* —— ⦿ —— ⦿ —— ⦿ —— { Render multi-factor view } —— ⦿ —— ⦿ —— ⦿ —— */
        return view('multi-factor.index');
    }


    /**
     * @function setupSms  | Public
     * —————————————————————————————————————————————————————————————————————————
     * Updates the user phone number and delivers a verification code by SMS.
     * @return View
     * The Blade view to load.
     */
    public function setupSms(): View
    {
        return view('multi-factor.setup', [
            'method' => 'sms-voice'
        ]);
    }


    /**
     * @function setupTotp  | Public
     * —————————————————————————————————————————————————————————————————————————
     * Displays the QR code used to set up an Authenticator application for
     * multi-factor authentication.
     * @return View
     * The Blade view to load.
     */
    public function setupTotp(): View
    {
        /* —— ⦿ —— ⦿ —— ⦿ —— { Retrieve user data } —— ⦿ —— ⦿ —— ⦿ —— */
        $userId = session('mfa_user_id');
        $user = User::findOrFail($userId);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Initialize Google2FA } —— ⦿ —— ⦿ —— ⦿ —— */
        $google2fa = new Google2FA();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Create a new secret key } —— ⦿ —— ⦿ —— ⦿ —— */
        $totpSecret = $google2fa->generateSecretKey();

        
        /* —— ⦿ —— ⦿ —— ⦿ —— { Create a new secret } —— ⦿ —— ⦿ —— ⦿ —— */
        $secret = Secret::updateOrCreate(
            ['user_id' => $user->id, 'type' => 'totp'],
            ['public_key' => Crypt::encryptString($totpSecret)]
        );


        /* —— ⦿ —— ⦿ —— ⦿ —— { Update user data } —— ⦿ —— ⦿ —— ⦿ —— */
        $methods = $user->enrolled_mfa_methods ?? [];

        if (!in_array('totp', $methods)) {
            $methods[] = 'totp';
        }

        $user->enrolled_mfa_methods = $methods;
        $user->save();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Create a new secret key } —— ⦿ —— ⦿ —— ⦿ —— */
        if (!$secret) {
            abort(500, 'An unexpected error occurred. Please try your request again later.');
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Build QR code } —— ⦿ —— ⦿ —— ⦿ —— */
        $qrCodeUrl = $google2fa->getQRCodeUrl(
            'ClementineSolutions',
            $user->email,
            $totpSecret
        );


        /* —— ⦿ —— ⦿ —— ⦿ —— { Render QR code as SVG } —— ⦿ —— ⦿ —— ⦿ —— */
        $renderer = new ImageRenderer(
            new RendererStyle(200),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);
        $svg = $writer->writeString($qrCodeUrl);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Redirect to setup } —— ⦿ —— ⦿ —— ⦿ —— */
        return view('multi-factor.setup', [
            'method' => 'totp',
            'qrCode' => $svg
        ]);
    }


    /**
     * @function sendSms   | Public
     * —————————————————————————————————————————————————————————————————————————
     * Send a new verification token by SMS.
     * @param Request
     * The incoming HTTP request data.
     * @return RedirectResponse
     * The Blade view to load.
     */
    public function sendSms(Request $request): RedirectResponse
    {
        /* —— ⦿ —— ⦿ —— ⦿ —— { Validate request } —— ⦿ —— ⦿ —— ⦿ —— */
        $validatedData = $request->validate([
            'phone' => ['required']
        ]);

        
        /* —— ⦿ —— ⦿ —— ⦿ —— { Retrieve user data } —— ⦿ —— ⦿ —— ⦿ —— */
        $userId = session('mfa_user_id');
        $user = User::findOrFail($userId);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Generate verification token } —— ⦿ —— ⦿ —— ⦿ —— */
        $verificationToken = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Create a new secret } —— ⦿ —— ⦿ —— ⦿ —— */
        $secret = Secret::updateOrCreate(
            ['user_id' => $user->id, 'type' => 'sms-voice'],
            [
                'private_key' => Hash::make($verificationToken),
                'expires_at' => Carbon::now()->addMinutes(15)
            ]
        );


        /* —— ⦿ —— ⦿ —— ⦿ —— { Check that secret exists } —— ⦿ —— ⦿ —— ⦿ —— */
        if (!$secret) {
            abort(500, 'An unexpected error occurred. Please try your request again later.');
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Update user data } —— ⦿ —— ⦿ —— ⦿ —— */
        $methods = $user->enrolled_mfa_methods ?? [];

        if (!in_array('sms-voice', $methods)) {
            $methods[] = 'sms-voice';
        }

        $user->phone = '+1' . $validatedData['phone'];
        $user->enrolled_mfa_methods = $methods;
        $user->save();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Initialize Twilio } —— ⦿ —— ⦿ —— ⦿ —— */
        $sid = env('TWILIO_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $twilio = new Client($sid, $authToken);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Send SMS } —— ⦿ —— ⦿ —— ⦿ —— */
        $message = $twilio->messages->create(
            $validatedData['phone'],
            array(
                "from" => env('TWILIO_PHONE'),
                "body" => "Here is your multi-factor code for Clementine Solutions: $verificationToken. Do not share this code with anyone!"
            )
        );


        /* —— ⦿ —— ⦿ —— ⦿ —— { Check that message exists } —— ⦿ —— ⦿ —— ⦿ —— */
        if (!$message) {
            abort(500, 'An unexpected error occurred. Please try your request again later.');
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Redirect to verify } —— ⦿ —— ⦿ —— ⦿ —— */
        return redirect('/multi-factor/verify/sms');
    }


    /**
     * @function renderSms  | Public
     * —————————————————————————————————————————————————————————————————————————
     * Allow users to enter a code for the SMS MFA challenge.
     * @param Request
     * The incoming HTTP request data.
     * @return RedirectResponse
     * The Blade view to load.
     */
    public function renderSms()
    {
        return view('multi-factor.verify');
    }


    /**
     * @function verifySms  | Public
     * —————————————————————————————————————————————————————————————————————————
     * Verify a verification token sent by text message.
     * @param Request
     * The incoming HTTP request data.
     * @return RedirectResponse
     * The Blade view to load.
     */
    public function verifySms(Request $request)
    {
        /* —— ⦿ —— ⦿ —— ⦿ —— { Validate request } —— ⦿ —— ⦿ —— ⦿ —— */
        $validatedData = $request->validate([
            'verification_code' => ['required']
        ]);

        
        /* —— ⦿ —— ⦿ —— ⦿ —— { Retrieve user data } —— ⦿ —— ⦿ —— ⦿ —— */
        $userId = session('mfa_user_id');
        $user = User::findOrFail($userId);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Retrieve secret data } —— ⦿ —— ⦿ —— ⦿ —— */
        $secret = Secret::where('user_id', $userId)
            ->where('type', 'sms-voice')
            ->latest()
            ->first();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Check if secret exists } —— ⦿ —— ⦿ —— ⦿ —— */
        if (!$secret) {
            return back()->withErrors([
                'verification_code' => 'Invalid identifier or secret.'
            ]);
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Check if secret expired } —— ⦿ —— ⦿ —— ⦿ —— */
        if (!Carbon::now()->lessThan($secret->expires_at)) {
            return back()->withErrors([
                'verification_code' => 'Verification code has expired.'
            ]);
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Verify secret } —— ⦿ —— ⦿ —— ⦿ —— */
        if (!Hash::check($validatedData['verification_code'], $secret->private_key)) {
            return back()->withErrors([
                'verification_code' => 'Invalid identifier or secret.'
            ]);
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Update user login data } —— ⦿ —— ⦿ —— ⦿ —— */
        $secret->last_used_at = now();
        $secret->private_key = null;
        $secret->expires_at = null;
        $user->last_login_ip = $request->ip();
        $user->last_login_at = now();
        $secret->save();
        $user->save();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Start user session } —— ⦿ —— ⦿ —— ⦿ —— */
        Auth::login($user);
        $request->session()->regenerate();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Redirect to dashboard } —— ⦿ —— ⦿ —— ⦿ —— */
        return redirect('/dashboard');
    }


    /**
     * @function VerifyTotp | Public
     * —————————————————————————————————————————————————————————————————————————
     * Verify a time-based one-time passcode (TOTP) from an Authenticator app.
     * @param Request
     * The incoming HTTP request data.
     * @return RedirectResponse
     * The Blade view to load.
     */
    public function verifyTotp(Request $request)
    {
        /* —— ⦿ —— ⦿ —— ⦿ —— { Validate request } —— ⦿ —— ⦿ —— ⦿ —— */
        $validatedData = $request->validate([
            'totp_code' => ['required', 'min:6']
        ]);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Retrieve user data } —— ⦿ —— ⦿ —— ⦿ —— */
        $userId = session('mfa_user_id');
        $user = User::findOrFail($userId);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Retrieve the secret } —— ⦿ —— ⦿ —— ⦿ —— */
        $secret = Secret::where('user_id', $userId)
            ->where('type', 'totp')
            ->latest()
            ->first();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Check is secret exists } —— ⦿ —— ⦿ —— ⦿ —— */
        if (!$secret) {
            return back()->withErrors([
                'totp_code' => 'Invalid identifier or secret.'
            ]);
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Decrypt the secret } —— ⦿ —— ⦿ —— ⦿ —— */
        $decrypted = Crypt::decryptString($secret->public_key);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Initialize Google2FA } —— ⦿ —— ⦿ —— ⦿ —— */
        $google2fa = new Google2FA();

        $testCode = $google2fa->getCurrentOtp($decrypted);
        logger()->info("Server OTP: $testCode, User entered: ".$validatedData['totp_code']);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Verify the secret } —— ⦿ —— ⦿ —— ⦿ —— */
        $valid = $google2fa->verifyKey($decrypted, $validatedData['totp_code'], 2);


        /* —— ⦿ —— ⦿ —— ⦿ —— { Check for auth errors } —— ⦿ —— ⦿ —— ⦿ —— */
        if (!$valid) {
            return back()->withErrors([
                'totp_code' => 'Invalid identifier or secret.'
            ]);
        }


        /* —— ⦿ —— ⦿ —— ⦿ —— { Update user login data } —— ⦿ —— ⦿ —— ⦿ —— */
        $secret->last_used_at = now();
        $user->last_login_ip = $request->ip();
        $user->last_login_at = now();
        $secret->save();
        $user->save();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Start user session } —— ⦿ —— ⦿ —— ⦿ —— */
        Auth::login($user);
        $request->session()->regenerate();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Redirect to dashboard } —— ⦿ —— ⦿ —— ⦿ —— */
        return redirect('/dashboard');
    }
}
