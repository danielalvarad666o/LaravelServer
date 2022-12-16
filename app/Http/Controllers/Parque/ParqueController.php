<?php

namespace App\Http\Controllers\Parque;

use App\Http\Controllers\Controller;
use App\Models\ModelosParque\InfoSensor;
use App\Models\ModelosParque\OwnerArea;
use App\Models\ModelosParque\Parque;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ParqueController extends Controller
{
    public function addParque(Request $request, $id_user)
    {
        $validacion = Validator::make(
            $request->all(), [
                'nombre' => "required|string|max:25",
                'reglas' => "required|string|max:1000",
                'medida_largoTerreno' => "required|integer",
                'medida_anchoTerreno' => "required|integer"
            ]
        );
        if ($validacion->fails()) {
            return response()->json([
                "status" => 400,
                "msg" => "No se cumplieron las validaciones",
                "error" => $validacion->errors(),
                "data" => null,
            ], 400);
        }

        $parque = new Parque();
        $parque->nombre = $request->nombre;
        $parque->dueño_id = $id_user;
        // $parque->dueño_id = $request->user()->id;
        $parque->reglas = $request->reglas;
        $parque->medida_largoTerreno = $request->medida_largoTerreno;
        $parque->medida_anchoTerreno = $request->medida_anchoTerreno;
        $parque->cantidad_entradas = 1;
        $parque->cantidad_salidas = 1;
        $parque->save();

        $areas = DB::select('select * from parque_areas where status = ?', [1]);
        foreach ($areas as $areas) {
            $ownerAreas = new OwnerArea();
            $ownerAreas->area_id = $areas->id;
            $ownerAreas->parque_id = $parque->id;
            $ownerAreas->save();
        }

        // $i = 0;
        // $j = 0;
        // $k = 0;
        $sensores = DB::select('select * from sensores where status = ?', [1]);

        foreach ($sensores as $sensores) {
            $infoSens = new InfoSensor();
            $infoSens->sensor_id = $sensores->id;
            $infoSens->parque_id = $parque->id;
            $mAreas = DB::select('select * from parque_areas where status = ?', [1]);
            foreach ($mAreas as $mareas => $hola) {
                $infoSens->area_parque = $hola->id;
                if (!$hola) {
                    foreach ($mAreas as $mAreas => $lol) {
                        $infoSens->area_parque = $lol->id;
                        $infoSens->save();

                    }
                } else {
                    $infoSens->save();
                }

            }
        }

        $mosSens = DB::select('select * from info_sensores where parque_id = ?', [$parque->id]);
        $mosAres = DB::select('select * from owners_areas where parque_id = ?', [$parque->id]);
        if ($parque->save()) {
            return response()->json([
                "status" => 201,
                "msg" => "Se insertaron datos de manera satisfactoria",
                "error" => null,
                "data" => $parque,
                "sensores" => $mosSens,
                "areas" => $mosAres,
            ], 201);
        }
    }

    public function getAllParques(Request $request, $id_user)
    {
        // $id = $request->user()->id;
        $id = $id_user;
        $parques = DB::table('parques')
            ->where('status', true)->where('dueño_id', $id)
            ->get();
        $user = DB::table('parques')->where('dueño_id', $id)->exists();
        if ($user) {
            return response()->json([
                "status" => 200,
                "msg" => "Informacion localizada",
                "error" => null,
                "data" => $parques,
            ], 200);
        } else {
            return response()->json([
                "status"=> 400,
                'info' => null,
                'msg' => 'No se encontro ningun parque',
            ]);
        }
    }

    public function getOnePark(Request $request, $id_user, $id)
    {
        $parqueActivo = DB::table('parques')->where('id', $id)->where('status', false)->exists();
        if ($parqueActivo) {
            return response()->json([
                'msg' => 'Este parque ya no se encuentra activo',
            ]);
        }
        // $idUser = $request->user()->id;
        $idUser = $id_user;
        // $userParque = DB::table('parques')->where('dueño_id', $idUser)->first();
        $user = DB::table('parques')->where('dueño_id', $idUser)->where('id', $id)->exists();
        if ($user) {
            $parque = Parque::find($id);
            $mosSens = DB::select('select * from info_sensores where parque_id = ?', [$parque->id]);
            $mosAres = DB::select('select * from owners_areas where parque_id = ?', [$parque->id]);
            if ($parque) {
                return response()->json([
                    'msg' => 'Se encontro la informacion',
                    'parque' => $parque,
                    'areas' => $mosAres,
                    'sensores' => $mosSens,
                ]);
            } else {
                return response()->json([
                    'msg' => 'No se encontro ese parque en especifico',
                ]);
            }
        } else {
            return response()->json([
                'info' => null,
                'msg' => 'No tienes acceso a este parque',
            ]);
        }
    }

    public function editarParque(Request $request, $id)
    {
        $validacion = Validator::Make(
            $request->all(), [
                'nombre' => "required|string|max:25",
                'reglas' => "required|string|max:1000",
                'medida_largoTerreno' => "required|integer",
                'medida_anchoTerreno' => "required|integer",
                'cantidad_entradas' => 'required|integer',
                'cantidad_salidas' => 'required|integer',
            ]
        );
        if ($validacion->fails()) {
            return response()->json([
                "status" => 400,
                "msg" => "No se cumplieron las validaciones",
                "error" => $validacion->errors(),
                "data" => null,
            ], 400);
        }

        $parqueActivo = DB::table('parques')->where('id', $id)->where('status', false)->exists();
        if ($parqueActivo) {
            return response()->json([
                'msg' => 'Este parque ya no se encuentra activo',
            ]);
        }

        $parque = Parque::find($id);

        if ($parque) {
            $parque->nombre = $request->nombre;
            $parque->reglas = $request->reglas;
            $parque->medida_largoTerreno = $request->medida_largoTerreno;
            $parque->medida_anchoTerreno = $request->medida_anchoTerreno;
            $parque->cantidad_entradas = $request->cantidad_entradas;
            $parque->cantidad_salidas = $request->cantidad_salidas;
            $parque->save();
            if ($parque->save()) {
                return response()->json([
                    "status" => 201,
                    "msg" => "Los datos se actualizaron de manera adecuada",
                    "error" => null,
                    "data" => $parque,
                ], 201);
            }
        } else {
            return response()->json([
                "status" => 400,
                "msg" => "Datos no validados",
                "error" => "El parque con el id:{$id} no fue encontrado",
                "data" => $request->all(),
            ], 400);
        }
    }

    public function borrarParque(Request $request, $id_user, $id)
    {
        $idUser = $id_user;
        // $idUser = $request->user()->id;
        $user = DB::table('parques')->where('dueño_id', $idUser)->where('id', $id)->exists();
        if ($user) {
            $parque = Parque::find($id);
            // $parqueActivo = Parque::where('id', $id)->where('status', true)->get();
            $parqueActivo = DB::table('parques')->where('id', $id)->where('status', true)->exists();
            if ($parqueActivo) {
                if ($parque) {
                    $parque->status = false;
                    $parque->save();
                    return response()->json([
                        "status" => 200,
                        "msg" => "Informacion eliminada",
                        "error" => null,
                    ]);
                }
            } else {
                return response()->json([
                    'msg' => 'Ese parque ya no se encuentra activo',
                ]);
            }
        } else {
            return response()->json([
                'msg' => 'No tienes acceso a este parque',
            ]);
        }
    }
}
