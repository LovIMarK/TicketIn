<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{

    /**
     * Get the ticket that this message belongs to.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Get the attachments associated with the message.
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    use HasFactory;
}
