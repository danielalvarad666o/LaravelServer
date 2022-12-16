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
            "nombre_area" => "Area Natural",
            "descripcion" => "En esta zona se encuentras las areas verdes del parque"
        ];
        $parque_data2 = [
            "nombre_area" => "Area de Comida",
            "descripcion" => "Ubicacion de la cafeteria y sus agregados"
        ];
        $parque_data3 = [
            "nombre_area" => "Zona de entretenimiento",
            "descripcion" => "En esta zona es donde se ubican los recursos recreativos"
        ];
        // $parque_data4 = [
        //     "nombre_area" => "Salidas",
        //     "descripcion" => "Zona de salidas"
        // ];

        $parque1 = new ParqueArea($parque_data1);
        $parque1->save();
        $parque2 = new ParqueArea($parque_data2);
        $parque2->save();
        $parque3 = new ParqueArea($parque_data3);
        $parque3->save();
        // $parque4 = new ParqueArea($parque_data4);
        // $parque4->save();

        // $parque_data = [
        //     "nombre" => "Default1",
        //     "reglas"=>"1. Ser limpio. 2. No tirar basura 3. Respetar el establecimiento",
        //     "medida_largoTerreno" => "1200",
        //     "medida_anchoTerreno" => "1220"
        // ];

        // $parqueDefault = new Parque($parque_data);

    }
}
