<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Call extends Model
{
    protected $fillable = [
        'uuid',
        'caller_id',
        'calle_id',
        'duration',
        'call_start',
        'call_end',
        'status',
        'end_reason',
    ];

    protected $casts = [
        'call_start' => 'datetime',
        'call_end' => 'datetime',
        'duration' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (Call $call) {
            $call->uuid ??= (string) Str::uuid();
        });
    }

    public function caller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'caller_id');
    }

    public function calle(): BelongsTo
    {
        return $this->belongsTo(User::class, 'calle_id');
    }
}
