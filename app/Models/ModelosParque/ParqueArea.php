<?php

namespace App\Models\ModelosParque;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParqueArea extends Model
{
    use HasFactory;
    protected $table = 'parque_areas';
    public function parque()
    {
        return $this->belongsTo(Post::class);
    }
}
