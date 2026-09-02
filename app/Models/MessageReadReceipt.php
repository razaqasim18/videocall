<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageReadReceipt extends Model
{
    protected $fillable = [
        'message_id',
        'user_id',
        'delivered_at',
        'read_at',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
    ];

    /**
     * Message.
     */
    public function message(): BelongsTo
    {
        return $this->belongsTo(
            Message::class
        );
    }

    /**
     * User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }
}
