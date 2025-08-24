<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Ticket model.
 *
 * Represents a support ticket with status/priority and an optional assigned agent.
 * Uses UUIDs for route model binding (see getRouteKeyName()).
 *
 * Allowed values:
 * - status: open | closed | in_progress
 * - priority: low | medium | high | null
 *
 * @property int $id
 * @property string $title
 * @property string $uuid
 * @property int $user_id
 * @property string|null $status
 * @property string|null $priority
 * @property int|null $agent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Ticket extends Model
{

    protected $fillable = [
        'title',
        'uuid',
        'user_id',
        'status',
        'priority',
        'agent_id',
    ];

    /**
     * CSS classes for the small priority dot indicator.
     *
     * Closed tickets are shown in gray regardless of priority.
     *
     * @return string
     */
    public function priorityDotStyle(): string
    {

        if($this->status === 'closed') {
            return 'inline-block w-2.5 h-2.5 rounded-full bg-gray-400 ring-1 ring-gray-500/30';
        }

        return match ($this->priority) {
            'low' => 'inline-block w-2.5 h-2.5 rounded-full bg-green-400 ring-1 ring-green-500/30',
            'medium' => 'inline-block w-2.5 h-2.5 rounded-full bg-yellow-400 ring-1 ring-yellow-500/30',
            'high' => 'inline-block w-2.5 h-2.5 rounded-full bg-red-500 ring-1 ring-red-500/30',
            default => 'inline-block w-2.5 h-2.5 rounded-full bg-gray-400 ring-1 ring-gray-500/30',
        };
    }

     /**
     * CSS classes for the priority badge.
     *
     * @return string
     */
    public function priorityBadgeStyle(): string
    {
        return match ($this->priority) {
            'low' => 'inline-flex justify-center items-center text-center rounded-full px-4 py-1 text-base font-semibold
                    text-green-400 border border-green-400/50 bg-green-400/5 ring-3 ring-inset ring-green-500/90',
            'medium' => 'inline-flex justify-center items-center text-center rounded-full px-4 py-1 text-base font-semibold
                        text-yellow-400 border border-yellow-400/50 bg-yellow-400/5 ring-3 ring-inset ring-yellow-500/30',
            'high' => 'inline-flex justify-center items-center text-center rounded-full px-4 py-1 text-base font-semibold
                    text-red-500 border border-red-500/50 bg-red-500/5 ring-3 ring-inset ring-red-500/90',
            default => 'inline-flex justify-center items-center text-center rounded-full px-4 py-1 text-base font-semibold
                        text-gray-400 border border-gray-400/50 bg-gray-400/5 ring-5 ring-inset ring-gray-50/60',
        };
    }

    /**
     * CSS classes for the status badge.
     *
     * @return string
     */
    public function statusBadgeStyle(): string
    {
        return match ($this->status) {
            'open' => 'inline-flex items-center justify-center text-center rounded-full px-2 py-1 text-sm font-semibold
                    text-blue-400 border border-blue-400/50 bg-blue-400/5 ring-3 ring-inset ring-blue-500/30',
            'closed' => 'inline-flex items-center justify-center text-center rounded-full px-2 py-1 text-sm font-semibold
                    text-gray-400 border border-gray-400/50 bg-gray-400/5 ring-3 ring-inset ring-gray-500/30',
            'in_progress' => 'inline-flex items-center justify-center text-center rounded-full px-2 py-1 text-sm font-semibold
                    text-blue-400 border border-blue-400/50 bg-blue-400/5 ring-3 ring-inset ring-blue-500/30',
            default => 'inline-flex items-center justify-center text-center rounded-full px-2 py-1 text-sm font-semibold
                    text-gray-400 border border-gray-400/50 bg-gray-400/5 ring-3 ring-inset ring-gray-500/30',
        };
    }

     /**
     * Messages associated with the ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Message>
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * First (oldest) message of the ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Message>
     */
    public function firstMessage()
    {
        return $this->hasOne(Message::class)->oldestOfMany();
    }

    /**
     * User who created the ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Ticket>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Agent assigned to the ticket (if any).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Ticket>
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    /**
     * Use UUIDs for route model binding.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'uuid';
    }


    use HasFactory;
}


