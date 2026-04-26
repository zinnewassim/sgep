<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipe extends Model
{
    protected $fillable = [
        'code',
        'libelle',
        'chef_equipe_id',
    ];

    public function chefEquipe(): BelongsTo
    {
        return $this->belongsTo(Employe::class, 'chef_equipe_id');
    }

    public function employes(): HasMany
    {
        return $this->hasMany(Employe::class);
    }

    public function utilisateurs(): HasMany
    {
        return $this->hasMany(Utilisateur::class);
    }
}
