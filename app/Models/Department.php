<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Department model.
 *
 * Represents an organizational unit that groups users.
 */
class Department extends Model
{
    use HasFactory;

    /**
     * Users that belong to this department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\User>
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
