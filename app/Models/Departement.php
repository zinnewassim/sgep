<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'libelle',
        'description',
    ];

    /**
     * Get all postes for the department.
     */
    public function postes(): HasMany
    {
        return $this->hasMany(Poste::class);
    }

    /**
     * Get all employees for the department.
     */
    public function employes(): HasMany
    {
        return $this->hasMany(Employe::class);
    }
}
