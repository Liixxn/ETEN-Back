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

Route::get("usuarios/refresh", [UsuarioController::class, "refresh"])->middleware(App\Http\Middleware\UserMiddleware::class);

Route::get("usuarios/ObtenerUnUsuario", [UsuarioController::class, "ObtenerUnUsuario"])->middleware(App\Http\Middleware\UserMiddleware::class);

Route::put("usuarios/ActualizarDatosUsuario", [UsuarioController::class, "ActualizarDatosUsuario"])->middleware(App\Http\Middleware\UserMiddleware::class);

//para ver si puedes Actualizar los datos del usuario
Route::post("usuarios/ComprobarContrasena", [UsuarioController::class, "ComprobarContrasena"])->middleware(App\Http\Middleware\UserMiddleware::class);

//para que el admin vea todos los usuarios
Route::get("usuarios/obtenerUsuarios", [UsuarioController::class, "obtenerUsuarios"])->middleware(App\Http\Middleware\AdminMiddleware::class);

//para que el admin vea los usuarios registrados y suscritos
Route::get("usuarios/obtenerTiposUsuarios", [UsuarioController::class, "obtenerTiposUsuarios"])->middleware(App\Http\Middleware\AdminMiddleware::class);
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
//para las estadisticas del admin, obtiene el numero de recetas por categoria
Route::get("recetas/ObtenerNumRecetasPorCategoria", [RecetaController::class, "ObtenerNumRecetasCategoria"])->middleware(App\Http\Middleware\AdminMiddleware::class);
//Para las estadisticas del admin para cambair el numero de recetas a mostrar
Route::post("recetas/CambiarNumeroRecetasPagina", [RecetaController::class, "CambiarNumeroRecetasPagina"])->middleware(App\Http\Middleware\AdminMiddleware::class);

//Para las recetas favoritas del usuario
Route::get("recetas/ObtenerIdRecetasFavoritas", [RecetaController::class, "ObtenerIdRecetasFavoritas"])->middleware(App\Http\Middleware\UserMiddleware::class);
Route::post("recetas/ObtenerRecetasPorId", [RecetaController::class, "ObtenerRecetasPorId"])->middleware(App\Http\Middleware\UserMiddleware::class);
Route::get("recetas/GuardarRecetaFavoritos/{id_receta}", [RecetaController::class, "GuardarRecetaFavoritos"])->middleware(App\Http\Middleware\UserMiddleware::class);
Route::get("recetas/EliminarRecetaFavoritos/{id_receta}", [RecetaController::class, "EliminarRecetaFavoritos"])->middleware(App\Http\Middleware\UserMiddleware::class);
Route::get("recetas/VerificarRecetaFavorita/{id_receta}", [RecetaController::class, "VerificarRecetaFavorita"])->middleware(App\Http\Middleware\UserMiddleware::class);
Route::post("recetas/ObtenerRecetaFavoritaUsuario", [RecetaController::class, "ObtenerRecetaFavoritaUsuario"]);
//paginacion
Route::get("recetas/ObtenerRecetasPorCategoria/{num_categoria}/{pagina}", [RecetaController::class, "ObtenerRecetasPorCategoria"]);

//info receta
Route::get("recetas/ObtenerUnaReceta/{id}", [RecetaController::class, "ObtenerUnaReceta"]);

// Buscador titulo
Route::post("recetas/BuscarReceta", [RecetaController::class, "BuscarReceta"]);

//Guardar cambios
Route::post("recetas/GuardarCambiosReceta", [RecetaController::class, "GuardarCambiosReceta"]);

/*
|--------------------------------------------------------------------------
| FIN Endpoints RECETAS
|---------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| Endpoints INGREDIENTES
|---------------------------------------------------------------------------
*/

//Buscador por ingredientes
Route::post("recetas/ingredientes/ObtenerRecetaIngrediente", [IngredienteController::class, "obtenerRecetaIngrediente"]);

//ingredientes dentro de info receta
Route::get("recetas/ingredientes/ingredientesUnaReceta/{id_receta}", [IngredienteController::class, "obtenerIngredientes"]);

/*
|--------------------------------------------------------------------------
| FIN Endpoints INGREDIENTES
|---------------------------------------------------------------------------
*/



/*
|--------------------------------------------------------------------------
| Endpoints OFERTAS
|---------------------------------------------------------------------------
*/

Route::get ("ofertas/ObtenerTodasOfertas",[OfertaController::class, "obtenerTodasOfertas"]);
Route::get ("ofertas/obtenerOfertasPorCategoria/{num_categoria}/{pagina}" ,[OfertaController::class, "obtenerOfertasPorCategoria"]);
Route::get ("ofertas/SumarVisitas/{id_oferta}", [OfertaController::class, "sumarVisita"])->middleware(App\Http\Middleware\UserMiddleware::class);

//para el administrador para ver que ofertas son las mas visitadas
Route::get("ofertas/ObtenerOfertasMasVisitadas", [OfertaController::class, "ObtenerOfertasMasVisitadas"])->middleware(App\Http\Middleware\AdminMiddleware::class);
/*
|--------------------------------------------------------------------------
| FIN Endpoints OFERTAS
|---------------------------------------------------------------------------
*/
