<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Paie extends Model
{
    protected $fillable = [
        'employe_id',
        'mois',
        'annee',
        'salaire_base',
        'primes',
        'deductions',
        'salaire_net',
    ];

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }
}
