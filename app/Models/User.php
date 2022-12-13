<?php

namespace App\Models;

use App\Models\ModelosParque\Parque;
use App\Models\ModelosParque\Tarjeta;
use App\Models\ModelosParque\Visitante;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];


    public function tarjeta()
    {
        return $this->hasOne(Tarjeta::class);
    }

    public function parques()
    {
        return $this->hasMany(Parque::class);
    }
    //Agregada, puede borrarse
    public function visitantes()
    {
        return $this->hasMany(Visitante::class);
    }
}
