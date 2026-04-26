<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pointage extends Model
{
    use HasFactory;

    protected $fillable = [
        'employe_id',
        'date',
        'heure_entree',
        'heure_sortie',
        'source',
        'statut',
        'overtime_hours',
        'latitude_entree',
        'longitude_entree',
        'latitude_sortie',
        'longitude_sortie',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get the employee associated with the pointage.
     */
    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }
}
