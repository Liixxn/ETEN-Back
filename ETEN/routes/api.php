<?php

use App\Http\Controllers\IngredienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\UsuarioController;
use App\Models\Receta;

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


//USUARIOS
Route::post("usuarios/Registro", [UsuarioController::class, "Registro"]);

Route::post("usuarios/login", [UsuarioController::class, "login"]);

Route::get("usuarios/ObtenerUnUsuario", [UsuarioController::class, "ObtenerUnUsuario"])->middleware(App\Http\Middleware\UserMiddleware::class);

Route::put("usuarios/ActualizarDatosUsuario", [UsuarioController::class, "ActualizarDatosUsuario"])->middleware(App\Http\Middleware\UserMiddleware::class);

Route::post("usuarios/ComprobarContrasena", [UsuarioController::class, "ComprobarContrasena"])->middleware(App\Http\Middleware\UserMiddleware::class);

Route::get("usuarios/obtenerUsuarios", [UsuarioController::class, "obtenerUsuarios"])->middleware(App\Http\Middleware\AdminMiddleware::class);







//RECETAS
Route::get("recetas/ObtenerRecetas", [RecetaController::class, "ObtenerRecetas"]);
Route::get("recetas/ObtenerRecetasPorCategoria/{num_categoria}/{pagina}", [RecetaController::class, "ObtenerRecetasPorCategoria"]);

Route::post("recetas/ObtenerRecetaIngrediente", [IngredienteController::class, "obtenerRecetaIngrediente"]);
Route::post("receta/ingredientes", [IngredienteController::class, "obtenerIngredientes"]);
//Para agregar y eliminar de favoritos
Route::post("recetas/GuardarRecetaFavoritos", [RecetaController::class, "GuardarRecetaFavoritos"]);
Route::post("recetas/EliminarRecetaFavoritos", [RecetaController::class, "EliminarRecetaFavoritos"]);
Route::post("recetas/ObtenerIdRecetasFavoritas", [RecetaController::class, "ObtenerIdRecetasFavoritas"]);

Route::post("recetas/ObtenerRecetas", [RecetaController::class, "ObtenerRecetas"]);
Route::get("recetas/ObtenerUnaReceta/{id}", [RecetaController::class, "ObtenerUnaReceta"]);

Route::post("recetas/ObtenerRecetasPorId", [RecetaController::class, "ObtenerRecetasPorId"]);

Route::get("recetas/VerificarRecetaFavorita/{id_receta}", [RecetaController::class, "VerificarRecetaFavorita"])->middleware(App\Http\Middleware\UserMiddleware::class);

// Buscador titulo
Route::post("recetas/BuscarReceta", [RecetaController::class, "BuscarReceta"]);






//OFERTAS
Route::get("ofertas/ObtenerOfertas", [OfertaController::class, "ObtenerOfertas"]);
