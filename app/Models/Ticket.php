<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Ticket extends Model
{

    /**
     * Get the CSS classes for the priority dot indicator.
     */
    public function priorityDotStyle(): string
    {
        return match ($this->priority) {
            'low' => 'inline-block w-2.5 h-2.5 rounded-full bg-green-400 ring-1 ring-green-500/30',
            'medium' => 'inline-block w-2.5 h-2.5 rounded-full bg-yellow-400 ring-1 ring-yellow-500/30',
            'high' => 'inline-block w-2.5 h-2.5 rounded-full bg-red-500 ring-1 ring-red-500/30',
            default => 'inline-block w-2.5 h-2.5 rounded-full bg-gray-400 ring-1 ring-gray-500/30',
        };
    }

    /**
     * Get the CSS classes for the priority badge.
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
     * Get the CSS classes for the status badge.
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
     * Get messages associated with the ticket.
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the first message of the ticket.
     */
    public function firstMessage()
    {
        return $this->hasOne(Message::class)->oldestOfMany();
    }

    /**
     * Get the user who created the ticket.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the agent assigned to the ticket.
     */
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }


    use HasFactory;
}


