<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Retard extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'employe_id',
        'date',
        'minutes',
        'motif',
    ];

    protected $casts = [
        'date' => 'date',
        'created_at' => 'datetime',
    ];

    /**
     * Get the employee associated with the retard.
     */
    public function employe(): BelongsTo
    {
        return $this->belongsTo(Employe::class);
    }
}
