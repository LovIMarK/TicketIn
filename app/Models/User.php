<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


/**
 * Application user model.
 *
 * Represents an authenticated user with a role and optional department.
 *
 * Allowed roles: user | agent | admin
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property int|null $department_id
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;


    /**
     * Return the list of supported roles.
     *
     * @return array<int, string>
     */
    public static function availableRoles(): array
    {
        return ['user', 'agent', 'admin'];
    }

    /**
     * Mass-assignable attributes.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'department_id',
    ];

    /**
     * Hidden attributes for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

     /**
     * The department this user belongs to (if any).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Department, \App\Models\User>
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Attribute casting rules.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
