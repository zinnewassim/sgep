<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DemandeCorrectionPointage extends Model
{
    protected $fillable = [
        'employe_id',
        'pointage_id',
        'motif',
        'nouvelle_heure_entree',
        'nouvelle_heure_sortie',
        'statut',
    ];

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }

    public function pointage(): BelongsTo
    {
        return $this->belongsTo(Pointage::class);
    }
}
