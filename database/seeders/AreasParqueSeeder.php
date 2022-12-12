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
    public function run()
    {
        $parque_data1 = [
            "nombre_area" => "Bosque",
            "descripcion" => "Un bosque magico donde los infantes son capaces de jugar a las escondidas"
        ];
        $parque_data2 = [
            "nombre_area" => "Zona de Juegos",
            "descripcion" => "Juegos como una rueda de la fortuna"
        ];
        $parque_data3 = [
            "nombre_area" => "Entradas",
            "descripcion" => "Zona de entradas"
        ];
        $parque_data4 = [
            "nombre_area" => "Salidas",
            "descripcion" => "Zona de salidas"
        ];

        $parque1 = new ParqueArea($parque_data1);
        $parque1->save();
        $parque2 = new ParqueArea($parque_data2);
        $parque2->save();
        $parque3 = new ParqueArea($parque_data3);
        $parque3->save();
        $parque4 = new ParqueArea($parque_data4);
        $parque4->save();
    }
}
