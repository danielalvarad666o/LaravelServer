<?php

namespace App\Http\Controllers\Parque;

use App\Http\Controllers\Controller;
use App\Models\ModelosParque\OwnerArea;
use App\Models\ModelosParque\Parque;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ParqueController extends Controller
{
    public function addParque(Request $request)
    {
        $validacion = Validator::make(
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

        $parque = new Parque();
        $parque->nombre = $request->nombre;
        $parque->dueño_id = $request->user()->id;
        $parque->reglas = $request->reglas;
        $parque->medida_largoTerreno = $request->medida_largoTerreno;
        $parque->medida_anchoTerreno = $request->medida_anchoTerreno;
        $parque->cantidad_entradas = $request->cantidad_entradas;
        $parque->cantidad_salidas = $request->cantidad_salidas;
        $parque->save();

        $areas = DB::select('select * from parque_areas where status = ?', [1]);
        foreach ($areas as $areas) {
            $ownerAreas = new OwnerArea();
            $ownerAreas->area_id = $areas->id;
            $ownerAreas->parque_id = $parque->id;
            $ownerAreas->save();
        }

        if ($parque->save()) {
            return response()->json([
                "status" => 201,
                "msg" => "Se insertaron datos de manera satisfactoria",
                "error" => null,
                "data" => $parque,
            ], 201);
        }
    }

    public function getAllParques(Request $request)
    {
        $id = $request->user()->id;
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
                'info' => null,
                'msg' => 'No se encontro ningun parque',
            ]);
        }
    }

    public function getOnePark(Request $request, $id)
    {
        $idUser = $request->user()->id;
        // $userParque = DB::table('parques')->where('dueño_id', $idUser)->first();
        $user = DB::table('parques')->where('dueño_id', $idUser)->where('id', $id)->exists();
        if ($user) {
            $parque = Parque::find($id);
            if ($parque) {
                return response()->json([
                    'msg' => 'Se encontro la informacion',
                    'data' => $parque,
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

        $parque = Parque::find($id);
        $parque->nombre = $request->nombre;
        $parque->reglas = $request->reglas;
        $parque->medida_largoTerreno = $request->medida_largoTerreno;
        $parque->medida_anchoTerreno = $request->medida_anchoTerreno;
        $parque->cantidad_entradas = $request->cantidad_entradas;
        $parque->cantidad_salidas = $request->cantidad_salidas;
        $parque->save();

        if ($parque) {
            if($parque->save()){
                return response()->json([
                    "status"        => 201,
                    "msg"           => "Los datos se actualizaron de manera adecuada",
                    "error"         => null,
                    "data"          => $parque
                ], 201);
            }
        } else {
            return response()->json([
                "status"    =>400,
                "msg"       =>"Datos no validados",
                "error"     =>"El parque con el id:{$id} no fue encontrado",
                "data"      =>$request->all()
            ], 400);
        }
    }

    public function borrarParque(Request $request, $id){
        $idUser = $request->user()->id;
        $user = DB::table('parques')->where('dueño_id', $idUser)->where('id', $id)->exists();
        if($user){
            $parque = Parque::find($id);
            // $parqueActivo = Parque::where('id', $id)->where('status', true)->get();
            $parqueActivo = DB::table('parques')->where('id', $id)->where('status', true)->exists();
            if($parqueActivo){
                if($parque){
                    $parque->status=false;
                    $parque->save();
                    return response()->json([
                        "status" => 200,
                        "msg" => "Informacion eliminada",
                        "error" => null
                    ]);
                }
            }else{
                return response()->json([
                    'msg'=>'Ese parque ya no se encuentra activo'
                ]);
            }
        }else{
            return response()->json([
                'msg'=>'No tienes acceso a este parque'
            ]);
        }
    }
}
