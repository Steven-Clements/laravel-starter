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

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Mfa Controller
 * —————————————————————————————————————————————————————————————————————————————
 * Defines create, read, update, and delete (CRUD) functionality for multi-
 * factor authentication operations.
 */
class MfaController extends Controller
{
    public function index(): View
    {
        return view('multi-factor.index');
    }
}
