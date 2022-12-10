<?php

<<<<<<< HEAD
=======
use App\Http\Controllers\Parque\ParqueController;
use App\Http\Controllers\Parque\SensorController;
use App\Http\Controllers\Parque\UsuarioController;
>>>>>>> 9e6cb941063e61dcf88de33546dfce8f91efd2d0
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
<<<<<<< HEAD
=======

Route::post("/registroDueño", [UsuarioController::class, "crearDueño"]);
Route::get("/pero", [SensorController::class, "getAllSensores"]);
Route::post("/addParque", [ParqueController::class, "addParque"]);
>>>>>>> 9e6cb941063e61dcf88de33546dfce8f91efd2d0
