<?php

namespace App\Http\Controllers\Parque;

use App\Http\Controllers\Controller;
use App\Models\ModelosParque\Tarjeta;
use App\Models\ModelosParque\Visitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisitanteController extends Controller
{
    public function crearTarjeta(){
        $tarjeta = new Tarjeta();
        $tarjeta->save();
        if($tarjeta->save()){
            return response()->json([
                'msg'=>'Se ha creado la tarjeta con exito'
            ]);
        }else{
            return response()->json([
                'msg'=>'Algo salio mal'
            ]);
        }
    }

    public function crearVisitante(Request $request, $tarjeta){
        $validacion = Validator::make(
            $request->all(), [
                'nombre' => "required|string|max:20",
                'apellidos' => "required|string|max:30",
                'edad' => "required|integer|min:1|max:120",
                'email' => "required|string|unique:users|email",
                'telefono' => "required|integer"
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

        $visitante = new Visitante();
        $visitante->usuario_id = $request->user()->id;
        $visitante->nombre = $request->nombre;
        $visitante->apellidos = $request->apellidos;
        $visitante->edad = $request->edad;
        $visitante->email = $request->email;
        $visitante->telefono = $request->telefono;
        $visitante->numero_tarjeta = $tarjeta;
        $visitante->save();

        if ($visitante->save()) {
            return response()->json([
                "status" => 201,
                "msg" => "Se ha registrado de manera satisfactoria",
                "error" => null,
                "data" => $visitante,
            ], 201);
        } else {
            return response()->json([
                "msg" => "Existe un error al registrar el usuario, por favor verifique que sea la informacion adecuada",
            ]);
        }
    }
}
