<?php

use App\Http\Controllers\Parque\ParqueController;
use App\Http\Controllers\Parque\SensorController;
use App\Http\Controllers\Parque\UsuarioController;
use App\Http\Controllers\Parque\VisitanteController;
use App\Models\ModelosParque\Visitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/registroDueno", [UsuarioController::class, "crearDueño"]);

Route::middleware(['verifyStatus'])->group(function(){
});

Route::post("/login",[UsuarioController::class,"InicioSesion"]);
Route::post("/telefonoregistr",[UsuarioController::class,"registrarSMS"]);
Route::get("/validarnumero/{url}",[UsuarioController::class,"numerodeverificacionmovil"])->name('validarnumero')->middleware('signed');

Route::get("/user/{id}", [UsuarioController::class,"UserInfo"]);

Route::middleware(['auth:sanctum'])->group(function () {

    //
    Route::post("/add/{id_user}", [ParqueController::class, "addParque"])->where("id_user", "[0-9]+");
    Route::get("/parques/{id_user}", [ParqueController::class, "getAllParques"])->where("id", "[0-9]+");
    Route::get("/parque/{id_user}/{id}", [ParqueController::class,"getOnePark"])->where("id", "[0-9]+")->where("id_user", "[0-9]+");
    Route::put("/editarpark/{id}", [ParqueController::class,"editarParque"])->where("id", "[0-9]+");
    Route::delete("/borrarpark/{id_user}/{id}", [ParqueController::class,"borrarParque"])->where("id_user", "[0-9]+")->where("id", "[0-9]+");

    //
    Route::post("/creartarjeta", [VisitanteController::class, "crearTarjeta"]);
    Route::post("/anadirvisitanteL/{id_user}/{id_parque}", [VisitanteController::class,"crearVisitante"])->where("id_user", "[0-9]+")->where("id_parque", "[0-9]+");
    Route::get("/visitantesL/{id_user}", [VisitanteController::class, "getAllVisitantes"])->where("id_user", "[0-9]+");
    Route::get("/visitante/{id_user}/{id}", [VisitanteController::class, "getOneVisitor"])->where("id_user", "[0-9]+")->where("id", "[0-9]+");
    Route::put("/editarvisit/{id}", [VisitanteController::class, "editarVisitante"])->where("id", "[0-9]+");
    Route::delete("/borrarvisit/{id_user}/{id}", [VisitanteController::class,"borrarVisitante"])->where("id_user", "[0-9]+")->where("id", "[0-9]+");

    //
    Route::get("/traerinfo/{id_user}/{sensor_key}", [SensorController::class, "getInfoSensor"])->where("id_user", "[0-9]+");//last info
    Route::get("/sensores", [SensorController::class, "getAllSensores"]);
    Route::get("/sens", [SensorController::class, "InfoSensores"]);
    Route::delete("/borrarsensor", [SensorController::class, "borrarSensor"]);

    //
    Route::get("/salirsesionL", [UsuarioController::class, "logout"]);

});