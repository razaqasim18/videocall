<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AgentPackage extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'description', 'price', 'coins', 'is_active'];

    public function transaction(): HasMany
    {
        return $this->hasMany(AgentPackageTransaction::class);
    }
}
