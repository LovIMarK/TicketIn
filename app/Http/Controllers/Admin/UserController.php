<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


/**
 * Admin user management controller.
 *
 * Handles listing, creation, edition, and deletion of users,
 * grouping by departments and enforcing admin-only access.
 *
 * Secured by 'auth' and 'role:admin' middleware.
 */
class UserController  extends Controller
{

    /**
     * Register authentication and admin-only middleware.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * List departments with their users ordered by name.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {

       $departments = Department::with(['users' => function ($query) {
                                  $query->orderBy('name');
                    }])->get();

        return view('admin.users.index', [
            'departments' => $departments,
        ]);
    }

     /**
     * Show the user creation form with available departments.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $departments = Department::all();

        return view('admin.users.create', [
            'departments' => $departments,
        ]);
    }

    /**
     * Persist a new user after validating input.
     *
     * Validation rules:
     * - name: required|string|max:255
     * - email: required|email|unique
     * - password: required|string|min:8|confirmed
     * - role: required in {admin, agent, user}
     * - department_id: required|exists:departments,id
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:8|confirmed',
            'role'          => 'required|in:admin,agent,user',
            'department_id' => 'required|exists:departments,id',
        ]);

        User::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'password'      => Hash::make($validated['password']),
            'role'          => $validated['role'],
            'department_id' => $validated['department_id'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the edit form for a given user (with roles and departments).
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        $departments = Department::all();
        $roles = User::availableRoles();

        return view('admin.users.edit', [
            'departments' => $departments,
            'user' => $user,
            'roles' => $roles,
        ]);

        return view('admin.users.edit', compact('user', 'departments'));
    }

    /**
     * Update an existing user after validating input.
     *
     * Validation rules:
     * - name: required|string|max:255
     * - email: required|email|unique (ignoring current user)
     * - password: nullable|string|min:6|confirmed (hashed if present)
     * - role: required in available roles
     * - department_id: required|exists:departments,id
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'      => 'nullable|string|min:6|confirmed',
            'role' => ['required', Rule::in(User::availableRoles())],
            'department_id' => 'required|exists:departments,id',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Soft/hard delete the given user (depending on model configuration),
     * then redirect back to the user index with a success flash message.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

}
