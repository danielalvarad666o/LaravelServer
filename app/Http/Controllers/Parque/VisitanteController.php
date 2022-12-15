<?php

namespace App\Http\Controllers\Parque;

use App\Http\Controllers\Controller;
use App\Models\ModelosParque\Tarjeta;
use App\Models\ModelosParque\Visitante;
use App\Models\ModelosParque\VisitanteParque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VisitanteController extends Controller
{
    public function crearTarjeta()
    {
        $tarjeta = new Tarjeta();
        $tarjeta->save();
        if ($tarjeta->save()) {
            return response()->json([
                'msg' => 'Se ha creado la tarjeta con exito',
            ]);
        } else {
            return response()->json([
                'msg' => 'Algo salio mal',
            ]);
        }
    }

    public function crearVisitante(Request $request, $id_user, $tarjeta)
    {
        $validacion = Validator::make(
            $request->all(), [
                'parque' => 'required|integer',
                'nombre' => "required|string|max:20",
                'apellidos' => "required|string|max:30",
                'edad' => "required|integer|min:1|max:120",
                'email' => "required|string|unique:users|email",
                'telefono' => "required|integer",
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
        // $visitante->usuario_id = $request->user()->id;
        $visitante->usuario_id = $id_user;
        $visitante->nombre = $request->nombre;
        $visitante->apellidos = $request->apellidos;
        $visitante->edad = $request->edad;
        $visitante->email = $request->email;
        $visitante->telefono = $request->telefono;
        $visitante->numero_tarjeta = $tarjeta;
        $visitante->save();

        $visiparque = new VisitanteParque();
        $visiparque->visitante_id = $visitante->id;
        $visiparque->parque_id = $request->parque;
        $visiparque->save();

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

    public function getAllVisitantes(Request $request, $id_user)
    {
        // $id = $request->user()->id;
        $id = $id_user;
        $visitantes = DB::table('visitantes')
            ->where('status', true)->where('usuario_id', $id)
            ->get();
        $user = DB::table('visitantes')->where('usuario_id', $id)->exists();
        if ($user) {
            return response()->json([
                "status" => 200,
                "msg" => "Informacion localizada",
                "error" => null,
                "data" => $visitantes,
            ], 200);
        } else {
            return response()->json([
                'info' => null,
                'msg' => 'No se encontro ningun visitante pertenenciente al usuario actual',
            ]);
        }
    }

    public function getOneVisitor(Request $request, $id_user, $id)
    {
        $visitanteActivo = DB::table('visitantes')->where('id', $id)->where('status', false)->exists();
        if ($visitanteActivo) {
            return response()->json([
                'msg' => 'Este parque ya no se encuentra activo',
            ]);
        }

        // $idUser = $request->user()->id;
        $idUser = $id_user;
        // $userParque = DB::table('parques')->where('dueño_id', $idUser)->first();
        $user = DB::table('visitantes')->where('usuario_id', $idUser)->where('id', $id)->exists();
        if ($user) {
            $visitante = Visitante::find($id);
            if ($visitante) {
                return response()->json([
                    'msg' => 'Se encontro la informacion',
                    'data' => $visitante,
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

    public function editarVisitante(Request $request, $id)
    {
        $validacion = Validator::Make(
            $request->all(), [
                'nombre' => "required|string|max:20",
                'apellidos' => "required|string|max:30",
                'edad' => "required|integer|min:1|max:120",
                'email' => "required|string|unique:users|email",
                'telefono' => "required|integer",
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

        $visitanteActivo = DB::table('visitantes')->where('id', $id)->where('status', false)->exists();
        if ($visitanteActivo) {
            return response()->json([
                'msg' => 'Este parque ya no se encuentra activo',
            ]);
        }

        $visitante = Visitante::find($id);

        if ($visitante) {
            $visitante->nombre = $request->nombre;
            $visitante->apellidos = $request->apellidos;
            $visitante->edad = $request->edad;
            $visitante->email = $request->email;
            $visitante->telefono = $request->telefono;
            $visitante->save();
            if ($visitante->save()) {
                return response()->json([
                    "status" => 201,
                    "msg" => "Los datos se actualizaron de manera adecuada",
                    "error" => null,
                    "data" => $visitante,
                ], 201);
            }
        } else {
            return response()->json([
                "status" => 400,
                "msg" => "Datos no validados",
                "error" => "El visitante con el id {$id} no fue encontrado",
                "data" => $request->all(),
            ], 400);
        }
    }

    public function borrarVisitante(Request $request, $id_user, $id){
        // $idUser = $request->user()->id;
        $idUser = $id_user;
        $user = DB::table('visitantes')->where('usuario_id', $idUser)->where('id', $id)->exists();
        if($user){
            $visitante = Visitante::find($id);
            // $parqueActivo = Parque::where('id', $id)->where('status', true)->get();
            $visitanteActivo = DB::table('visitantes')->where('id', $id)->where('status', true)->exists();
            if($visitanteActivo){
                if($visitante){
                    $visitante->status=false;
                    $visitante->save();
                    return response()->json([
                        "status" => 200,
                        "msg" => "Informacion eliminada",
                        "error" => null
                    ]);
                }
            }else{
                return response()->json([
                    'msg'=>'Ese visitante ya no se encuentra activo'
                ]);
            }
        }else{
            return response()->json([
                'msg'=>'No tienes acceso a este visitante'
            ]);
        }
    }
}
