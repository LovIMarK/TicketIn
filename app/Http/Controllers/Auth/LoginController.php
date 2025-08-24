<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Traits\RedirectsByRole;


/**
 * Authentication controller for handling user login.
 *
 * Displays the login form, validates credentials, authenticates the user,
 * regenerates the session to prevent fixation, and redirects based on role.
 */
class LoginController extends Controller
{
    use RedirectsByRole;

    /**
     * Register middleware guards for login/logout routes.
     *
     * - 'guest' for all actions except logout
     * - 'auth' only for logout
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

     /**
     * Show the login form view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Attempt to authenticate the user and redirect by role on success.
     *
     * Validation:
     * - email: required|string|email
     * - password: required|string|min:8
     *
     * Side effects:
     * - Regenerates the session on successful authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);


        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended($this->redirectByRole(Auth::user()))
                ->with('status', 'Login successful!');

        }

        return back()->withErrors([
            'email' => 'Invalid credentials.',
        ])->onlyInput('email');
    }


}
