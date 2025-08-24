<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * Handles user logout.
 *
 * Terminates the authenticated session, invalidates session data,
 * regenerates the CSRF token, and redirects to the public landing page.
 */
class LogoutController extends Controller {
    public function perform(Request $request) {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }
}
