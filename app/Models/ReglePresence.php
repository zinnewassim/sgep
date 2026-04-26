<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReglePresence extends Model
{
    protected $fillable = [
        'label',
        'description',
        'start_time',
        'end_time',
        'grace_period_minutes',
    ];

    public function employes(): HasMany
    {
        return $this->hasMany(Employe::class, 'regle_presence_id');
    }
}
