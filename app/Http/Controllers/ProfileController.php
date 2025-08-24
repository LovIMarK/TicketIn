<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

/**
 * User profile controller.
 *
 * Requires authentication and exposes endpoints to view and update
 * the authenticated user's profile.
 */
class ProfileController extends Controller
{
    /**
     * Register auth middleware.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the authenticated user's profile page.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', [
            'user' => $user,
        ]);
    }
}
