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

Route::post("/registroDueño", [UsuarioController::class, "crearDueño"]);
Route::get("/pero", [SensorController::class, "getAllSensores"]);

Route::middleware(['verifyStatus'])->group(function(){
Route::post("/login",[UsuarioController::class,"InicioSesion"]);
});

Route::post("/telefonoregistr",[UsuarioController::class,"registrarSMS"]);
Route::get("/validarnumero/{url}",[UsuarioController::class,"numerodeverificacionmovil"])->name('validarnumero')->middleware('signed');


Route::middleware(['auth:sanctum'])->group(function () {
    //
    Route::post("/addParque", [ParqueController::class, "addParque"]);
    Route::get("/traerparques", [ParqueController::class, "getAllParques"]);
    Route::get("/traeparque/{id}", [ParqueController::class,"getOnePark"])->where("id", "[0-9]+");
    Route::put("/editarparque/{id}", [ParqueController::class,"editarParque"])->where("id", "[0-9]+");
    Route::delete("/borrarParque/{id}", [ParqueController::class,"borrarParque"]);

    //
    Route::post("/tarjeta", [VisitanteController::class, "crearTarjeta"]);
    Route::post("/addVisitante/{tarjeta}", [VisitanteController::class,"crearVisitante"])->where("id", "[0-9]+");
    Route::get("/traervisitantes", [VisitanteController::class, "getAllVisitantes"]);
    Route::get("/traevisitante/{id}", [VisitanteController::class, "getOneVisitor"])->where("id", "[0-9]+");
    Route::put("/editarvisitante/{id}", [VisitanteController::class, "editarVisitante"])->where("id", "[0-9]+");
    Route::delete("/borrarVisitante/{id}", [VisitanteController::class,"borrarVisitante"]);

    //
    Route::get("/logout", [UsuarioController::class, "logout"]);
});