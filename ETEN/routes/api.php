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


/*
|--------------------------------------------------------------------------
| Endpoints USUARIOS
|---------------------------------------------------------------------------
*/

Route::post("usuarios/Registro", [UsuarioController::class, "Registro"]);

Route::post("usuarios/login", [UsuarioController::class, "login"]);

Route::get("usuarios/ObtenerUnUsuario", [UsuarioController::class, "ObtenerUnUsuario"])->middleware(App\Http\Middleware\UserMiddleware::class);

Route::put("usuarios/ActualizarDatosUsuario", [UsuarioController::class, "ActualizarDatosUsuario"])->middleware(App\Http\Middleware\UserMiddleware::class);

Route::post("usuarios/ComprobarContrasena", [UsuarioController::class, "ComprobarContrasena"])->middleware(App\Http\Middleware\UserMiddleware::class);

Route::get("usuarios/obtenerUsuarios", [UsuarioController::class, "obtenerUsuarios"])->middleware(App\Http\Middleware\AdminMiddleware::class);

/*
|--------------------------------------------------------------------------
| FIN Endpoints USUARIOS
|---------------------------------------------------------------------------
*/




/*
|--------------------------------------------------------------------------
| Endpoints RECETAS
|---------------------------------------------------------------------------
*/

//para las estadisticas del admin todavia no implementada
Route::get("recetas/ObtenerRecetas", [RecetaController::class, "ObtenerRecetas"])->middleware(App\Http\Middleware\AdminMiddleware::class);

//Para las recetas favoritas del usuario
Route::get("recetas/ObtenerIdRecetasFavoritas", [RecetaController::class, "ObtenerIdRecetasFavoritas"])->middleware(App\Http\Middleware\UserMiddleware::class);
Route::post("recetas/ObtenerRecetasPorId", [RecetaController::class, "ObtenerRecetasPorId"])->middleware(App\Http\Middleware\UserMiddleware::class);
Route::get("recetas/GuardarRecetaFavoritos/{id_receta}", [RecetaController::class, "GuardarRecetaFavoritos"])->middleware(App\Http\Middleware\UserMiddleware::class);
Route::get("recetas/EliminarRecetaFavoritos/{id_receta}", [RecetaController::class, "EliminarRecetaFavoritos"])->middleware(App\Http\Middleware\UserMiddleware::class);
Route::get("recetas/VerificarRecetaFavorita/{id_receta}", [RecetaController::class, "VerificarRecetaFavorita"])->middleware(App\Http\Middleware\UserMiddleware::class);

//paginacion
Route::get("recetas/ObtenerRecetasPorCategoria/{num_categoria}/{pagina}", [RecetaController::class, "ObtenerRecetasPorCategoria"]);



//voy por aquiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii


Route::post("recetas/ObtenerRecetaIngrediente", [IngredienteController::class, "obtenerRecetaIngrediente"]);
Route::post("receta/ingredientes", [IngredienteController::class, "obtenerIngredientes"]);
//Para agregar y eliminar de favoritos

Route::get("recetas/ObtenerUnaReceta/{id}", [RecetaController::class, "ObtenerUnaReceta"]);

// Buscador titulo
Route::post("recetas/BuscarReceta", [RecetaController::class, "BuscarReceta"]);

/*
|--------------------------------------------------------------------------
| FIN Endpoints RECETAS
|---------------------------------------------------------------------------
*/



/*
|--------------------------------------------------------------------------
| Endpoints OFERTAS
|---------------------------------------------------------------------------
*/

Route::get("ofertas/ObtenerOfertas", [OfertaController::class, "ObtenerOfertas"]);

/*
|--------------------------------------------------------------------------
| FIN Endpoints OFERTAS
|---------------------------------------------------------------------------
*/
