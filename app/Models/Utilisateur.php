<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Laravel\Sanctum\HasApiTokens;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Employe;

class Utilisateur extends Authenticatable implements LaratrustUser
{
    use HasFactory, Notifiable, HasRolesAndPermissions, SoftDeletes;

    protected $table = 'utilisateurs';

    protected $fillable = [
        'uuid',
        'nom',
        'prenom',
        'email',
        'telephone',
        'mot_de_passe',
        'etat',
        'derniere_connexion_at',
        'photo_url',
        'equipe_id',
    ];

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    protected $hidden = [
        'mot_de_passe',
    ];

    protected $casts = [
        'derniere_connexion_at' => 'datetime',
        'mot_de_passe' => 'hashed',
    ];

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    public function employe()
    {
        return $this->hasOne(Employe::class, 'utilisateur_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->notifications()->where('lu', false);
    }
}
