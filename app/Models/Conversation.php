<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conversation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'created_by',
    ];

    protected $casts = [
        'created_by' => 'integer',
    ];

    /**
     * User who created the conversation.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * All participants.
     */
    public function participants(): HasMany
    {
        return $this->hasMany(
            ConversationParticipant::class
        );
    }

    /**
     * Users participating in this conversation.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'conversation_participants'
        )
            ->withPivot([
                'joined_at',
                'left_at',
                'last_read_at',
                'is_muted',
            ])
            ->withTimestamps();
    }

    /**
     * All messages.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Latest message.
     */
    public function latestMessage(): HasOne
    {
        return $this->hasOne(Message::class)
            ->latestOfMany();
    }
}
