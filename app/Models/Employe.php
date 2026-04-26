<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employe extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'utilisateur_id',
        'departement_id',
        'poste_id',
        'matricule',
        'nom',
        'prenom',
        'email',
        'telephone',
        'date_naissance',
        'date_embauche',
        'genre',
        'cin',
        'cnss',
        'adresse',
        'manager_id',
        'equipe_id',
        'regle_presence_id',
        'statut',
        'type_contrat',
    ];

    /**
     * Get the manager associated with the employee.
     */
    public function manager(): BelongsTo
    {
        return $this->belongsTo(Employe::class, 'manager_id');
    }

    /**
     * Get the team the employee belongs to.
     */
    public function equipe(): BelongsTo
    {
        return $this->belongsTo(Equipe::class);
    }

    /**
     * Get the presence rule for the employee.
     */
    public function reglePresence(): BelongsTo
    {
        return $this->belongsTo(ReglePresence::class, 'regle_presence_id');
    }

    public function contrats(): HasMany
    {
        return $this->hasMany(Contrat::class);
    }

    public function paies(): HasMany
    {
        return $this->hasMany(Paie::class);
    }

    public function sanctions(): HasMany
    {
        return $this->hasMany(Sanction::class);
    }

    public function heureSups(): HasMany
    {
        return $this->hasMany(HeureSup::class);
    }

    public function plannings(): HasMany
    {
        return $this->hasMany(Planning::class);
    }

    public function commentaires(): HasMany
    {
        return $this->hasMany(Commentaire::class);
    }

    /**
     * Get the user account associated with the employee.
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    /**
     * Get the department the employee belongs to.
     */
    public function departement(): BelongsTo
    {
        return $this->belongsTo(Departement::class);
    }

    /**
     * Get the poste the employee holds.
     */
    public function poste(): BelongsTo
    {
        return $this->belongsTo(Poste::class);
    }

    /**
     * Get all pointages for the employee.
     */
    public function pointages(): HasMany
    {
        return $this->hasMany(Pointage::class);
    }

    /**
     * Get all absences for the employee.
     */
    public function absences(): HasMany
    {
        return $this->hasMany(Absence::class);
    }
}
