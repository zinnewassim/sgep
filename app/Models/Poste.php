<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poste extends Model
{
    use HasFactory;
    protected $table = 'poste';

    protected $fillable = [
        'code',
        'libelle',
        'departement_id',
        'description',
        'grade',
    ];

    /**
     * Get the department that the poste belongs to.
     */
    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    /**
     * Get all employees holding this poste.
     */
    public function employes(): HasMany
    {
        return $this->hasMany(Employe::class);
    }
}
