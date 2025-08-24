<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use \App\Models\Department;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Traits\RedirectsByRole;


/**
 * User registration controller.
 *
 * Displays the registration form, validates input, creates the user,
 * authenticates them, and redirects based on role.
 *
 * Secured by the 'guest' middleware.
 */
class RegisterController extends Controller
{
    use RedirectsByRole;

    /**
     * Register guest-only middleware.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the registration form with department options.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register',
        [
            'departments' => Department::all(),
        ]);
    }


    /**
     * Register a new user, hash the password, log them in, and redirect by role.
     *
     * Validation rules:
     * - name: required|string|max:255
     * - department_id: required|exists:departments,id
     * - email: required|string|email|max:255|unique:users
     * - password: required|string|min:8|confirmed
     *
     * Side effects:
     * - Persists the user
     * - Hashes the password
     * - Authenticates the user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'department_id'=>'required|exists:departments,id',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        Auth::login($user);

        return redirect()->intended($this->redirectByRole($user))
        ->with('status', 'Registration successful! Welcome to the ticketing system.');

    }


}
