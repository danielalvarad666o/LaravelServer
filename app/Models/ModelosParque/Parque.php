<?php

namespace App\Models\ModelosParque;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parque extends Model
{
    use HasFactory;
    protected $table = 'parques';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function areas()
    {
        return $this->hasMany(ParqueArea::class);
    }
    public function sensores()
    {
        return $this->hasMany(Sensor::class);
    }
}
