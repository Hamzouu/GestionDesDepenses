<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'approved',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'approved' => 'integer', // Ajout de la colonne 'approved' comme boolean
        'password' => 'hashed',
    ];

    
    public function participatedActivities()
    {
        return $this->belongsToMany(Activity::class, 'participates', 'user_id', 'activity_id');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'participates', 'user_id', 'activity_id');
    }

    // Relation activitySuperuser avec la table activities
    public function activitySuperuser()
    {
        return $this->hasMany(Activity::class, 'super_user_id');
    }

    // Vérifie si l'utilisateur est un super utilisateur
    public function isSuperUser()
    {
        // Vérifie si l'utilisateur a au moins une activité en tant que super utilisateur
        return $this->activitySuperuser()->exists();
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::class, 'expense_participants');
    }
}
