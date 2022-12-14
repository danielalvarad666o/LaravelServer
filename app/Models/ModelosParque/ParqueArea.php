<?php

namespace App\Models\ModelosParque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParqueArea extends Model
{
    use HasFactory;
    protected $table = 'parque_areas';
    //Agregada, puede borrarse
    public function parque()
    {
        return $this->belongsTo(Parque::class);
    }
}
