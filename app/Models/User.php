<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
<<<<<<< HEAD
=======

use App\Models\ModelosParque\Tarjeta;
>>>>>>> 9e6cb941063e61dcf88de33546dfce8f91efd2d0
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
<<<<<<< HEAD
=======
    protected $table = 'users';
>>>>>>> 9e6cb941063e61dcf88de33546dfce8f91efd2d0

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
<<<<<<< HEAD
=======

    public function tarjeta()
    {
        return $this->hasOne(Tarjeta::class);
    }

>>>>>>> 9e6cb941063e61dcf88de33546dfce8f91efd2d0
}
