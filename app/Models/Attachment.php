<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * Attachment model.
 *
 * Represents a file uploaded and linked to a ticket message.
 * Mass-assignable fields: file_name, file_path, file_type, message_id.
 *
 * @property int $id
 * @property string $file_name
 * @property string $file_path
 * @property string $file_type
 * @property int $message_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Attachment extends Model
{

    protected $fillable = [
        'file_name',
        'file_path',
        'file_type',
        'message_id',
    ];

    use HasFactory;
}
