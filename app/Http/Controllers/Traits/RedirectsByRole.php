<?php


namespace App\Http\Controllers\Traits;

/**
 * Role-based redirect helper.
 *
 * Resolves the post-authentication landing route based on the user's role.
 * Expects the following named routes to exist: 'admin.home', 'agent.home',
 * 'user.home', and 'index'.
 */
trait RedirectsByRole
{
    /**
     * Get the intended redirect URL for the given user based on role.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable|\App\Models\User $user
     * @return string
     */
    protected function redirectByRole($user)
    {
        return match ($user->role) {
            'admin' => route('admin.home'),
            'agent' => route('agent.home'),
            'user' => route('user.home'),
            default => route('index'),
        };
    }
}
