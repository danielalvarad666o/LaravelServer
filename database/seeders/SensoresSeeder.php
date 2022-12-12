<?php

namespace Database\Seeders;

use App\Models\ModelosParque\Sensor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SensoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sensor_data1 = [
            'nombre_sensor' => 'gas_co',
            'feed_key' => 'viyda.gas-co',
            'informacion' => 'Medidor de Monoxido de Carbono'
        ];
        $sensor_data2 = [
            'nombre_sensor' => 'gash',
            'feed_key' => 'viyda.gash',
            'informacion' => 'Medidor de humo'
        ];
        $sensor_data3 = [
            'nombre_sensor' => 'gaslp',
            'feed_key' => 'viyda.gaslp',
            'informacion' => 'Medidor de gas'
        ];
        $sensor_data4 = [
            'nombre_sensor' => 'humedad',
            'feed_key' => 'viyda.humedad',
            'informacion' => 'Medidor de humedad'
        ];
        $sensor_data5 = [
            'nombre_sensor' => 'temperatura',
            'feed_key' => 'viyda.temperatura',
            'informacion' => 'Medidor de temperatura'
        ];
        $sensor_data6 = [
            'nombre_sensor' => 'ultrasonico',
            'feed_key' => 'viyda.ultrasonico',
            'informacion' => 'Medidor de distancia por medio de ultrasonido'
        ];

        $sensor1 = new Sensor($sensor_data1);
        $sensor1->save();
        $sensor2 = new Sensor($sensor_data2);
        $sensor2->save();
        $sensor3 = new Sensor($sensor_data3);
        $sensor3->save();
        $sensor4 = new Sensor($sensor_data4);
        $sensor4->save();
        $sensor5 = new Sensor($sensor_data5);
        $sensor5->save();
        $sensor6 = new Sensor($sensor_data6);
        $sensor6->save();
    }
}
