<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\UsuarioController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Routes::get ("recetas/VerReceta/{nombreReceta}",[RecetaController::class, "VerReceta"]);
Routes::get ("recetas/BuscarReceta/{titulo}",[RecetaController::class, "BuscarReceta"]);
Routes::get ("ofertas/BuscarOferta",[OfertaController::class, "BuscarOferta"]);


Routes::post ("usuarios/CrearUsuario",[UsuarioController::class, "CrearUsuario"]);
Routes::post ("usuarios/login",[UsuarioController::class, "login"]);
Routes::post ("usuarios/Registro",[UsuarioController::class, "Registro"]);

Ruotes::put ("usuarios/ActualizarDatosUsuario",[UsuarioController::class, "ActualizarDatosUsuario"]);
Routes::put ("recetas/updateEstadoReceta", [RecetaController::class, "updateEstadoReceta"]);


