<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Ticket extends Model
{
    // Updated fillable to match your new column names
    protected $fillable = [
        'ticket_no',
        'senderable_type',
        'senderable_id',
        'subject',
        'message',
        'priority',
        'status',
    ];

    public function creator(): MorphTo
    {
        return $this->morphTo('creator', 'senderable_type', 'senderable_id');
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class);
    }
}
