<?php

namespace App\Models\ModelosParque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;
    protected $table = 'sensores';
    // public function parque()
    // {
    //     return $this->belongsTo(Parque::class);
    // }
    //Agregada y remplaza a la de arriba, puede borrarse
    public function parques()
    {
        return $this->belongsToMany(Parque::class);
    }
}
