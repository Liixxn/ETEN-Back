<?php

use App\Http\Controllers\IngredienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\UsuarioController;


/*
|--------------------------------------------------------------------------
| API Routes
|---------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::get ("ofertas/ObtenerOfertas",[OfertaController::class, "ObtenerOfertas"]);
Route::get ("recetas/ObtenerRecetas" ,[RecetaController::class, "ObtenerRecetas"]);

Route::post ("recetas/ObtenerRecetaIngrediente", [IngredienteController::class, "obtenerRecetaIngrediente"]);
Route::post ("receta/ingredientes",[IngredienteController::class, "obtenerIngredientes"]);

Route::post ("usuarios/login",[UsuarioController::class, "login"]);
Route::post ("usuarios/Registro",[UsuarioController::class, "Registro"]);

Route::post ("recetas/ObtenerRecetas", [RecetaController::class, "ObtenerRecetas"]);
Route::get ("recetas/ObtenerUnaReceta/{id}", [RecetaController::class, "ObtenerUnaReceta"]);



//todavia no se usa
//Route::get ("recetas/VerReceta/{nombreReceta}",[RecetaController::class, "VerReceta"]);
//Route::get ("recetas/BuscarReceta/{titulo}",[RecetaController::class, "BuscarReceta"]);
//Route::get ("recetas/RecetasUsuario/{id}",[UsuarioController::class, "RecetasUsuario"]);

//Route::post ("usuarios/obtenerUsuarios",[UsuarioController::class, "obtenerUsuarios"]);

//Route::put ("usuarios/ActualizarDatosUsuario",[UsuarioController::class, "ActualizarDatosUsuario"]);
//Route::put ("recetas/updateEstadoReceta", [RecetaController::class, "updateEstadoReceta"]);


