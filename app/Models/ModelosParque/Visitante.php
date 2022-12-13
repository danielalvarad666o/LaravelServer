<?php

namespace App\Models\ModelosParque;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitante extends Model
{
    use HasFactory;
    protected $table = 'visitantes';

    //Agrega, puede borrarse
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
