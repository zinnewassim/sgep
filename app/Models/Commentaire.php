<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commentaire extends Model
{
    protected $fillable = [
        'utilisateur_id',
        'employe_id',
        'contenu',
    ];

    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }
}
