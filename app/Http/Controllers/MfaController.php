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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;
use PragmaRX\Google2FA\Google2FA;

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
     * @function Setup an Authenticator  | Public
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
     * @function Verify a TOTP  | Public
     * —————————————————————————————————————————————————————————————————————————
     * Verify a time-based one-time passcode (TOTP) from an Authenticator app.
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


        /* —— ⦿ —— ⦿ —— ⦿ —— { Start user session } —— ⦿ —— ⦿ —— ⦿ —— */
        Auth::login($user);
        $request->session()->regenerate();


        /* —— ⦿ —— ⦿ —— ⦿ —— { Redirect to dashboard } —— ⦿ —— ⦿ —— ⦿ —— */
        return redirect('/dashboard');
    }
}
