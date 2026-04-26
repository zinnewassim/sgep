<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeureSup extends Model
{
    protected $fillable = [
        'employe_id',
        'date',
        'nombre_heures',
        'motif',
        'statut',
    ];

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }
}
