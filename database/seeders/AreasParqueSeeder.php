<?php

namespace Database\Seeders;

use App\Models\ModelosParque\Parque;
use App\Models\ModelosParque\ParqueArea;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreasParqueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $user;
    protected $parque;
    public function run(Parque $parque)
    {
        $this->parque = $parque;

        ParqueArea::insert([
            ['parque_id' => $parque->id],
            ['nombre_area' => 'Bosque'],
            ['descripcion' => 'Un bosque donde los mas pequeños pueden perderse']
        ]);
    }
}
