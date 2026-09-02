<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'conversation_id',
        'user_id',
        'type',
        'body',
        'url',
        'reply_to_message_id',
        'edited_at',
    ];

    protected $casts = [
        'edited_at' => 'datetime',
    ];

    /**
     * Conversation this message belongs to.
     */
    public function conversation(): BelongsTo
    {
        return $this->belongsTo(
            Conversation::class
        );
    }

    /**
     * User who sent the message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class
        );
    }

    /**
     * Message that this message is replying to.
     */
    public function replyTo(): BelongsTo
    {
        return $this->belongsTo(
            Message::class,
            'reply_to_message_id'
        );
    }

    /**
     * Messages that are replies to this message.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(
            Message::class,
            'reply_to_message_id'
        );
    }

    /**
     * Attachments.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(
            MessageAttachment::class
        );
    }

    /**
     * Read receipts.
     */
    public function readReceipts(): HasMany
    {
        return $this->hasMany(
            MessageReadReceipt::class
        );
    }

    /**
     * Check whether this is a text message.
     */
    public function isText(): bool
    {
        return $this->type === 'text';
    }

    /**
     * Check whether this is an image.
     */
    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    /**
     * Check whether this is a video.
     */
    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    /**
     * Check whether this is a link.
     */
    public function isLink(): bool
    {
        return $this->type === 'link';
    }
}
