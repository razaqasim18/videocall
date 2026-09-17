<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgentPackageTransaction extends Model
{
    protected $fillable = [
        'agent_package_id',
        'agent_id',
        'price',
        'coins',
        'proof',
        'status',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(AgentPackage::class, 'agent_package_id', 'id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id', 'id');
    }
}
