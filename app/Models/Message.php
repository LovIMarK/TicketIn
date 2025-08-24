<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Message model.
 *
 * Represents a user-authored message on a support ticket.
 *
 * @property int $id
 * @property string $content
 * @property int $ticket_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Message extends Model
{

    protected $fillable = [
        'content',
        'ticket_id',
        'user_id',
    ];

    /**
     * Ticket that this message belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Ticket, \App\Models\Message>
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    /**
     * Author of the message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, \App\Models\Message>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

   /**
     * Attachments associated with this message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Attachment>
     */
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    use HasFactory;
}
