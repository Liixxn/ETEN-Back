<?php

namespace App\Http\Controllers;

use App\Models\Config_recetasOfertas;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Oferta;
use App\Models\Usuario;
use App\Models\UsuarioOferta;

class OfertaController extends Controller
{
    public function obtenerTodasOfertas()
    {
        $ofertas = Oferta::get([
            'id', 'nombreOferta',
            'precioActual', 'precioAnterior', 'imagenOferta', 'urlOferta', 'categoria'
        ])->toArray();
        return $ofertas;
    }

    public function sumarVisita($id_oferta)
    {
        $usuario = JWTAuth::user();

        $usuarioEncontrado = Usuario::find($usuario->id);
        $ofertaEncontrada = Oferta::find($id_oferta);

        if (!is_null($usuarioEncontrado) && !is_null($ofertaEncontrada)) {
            $ofertaActualizar = UsuarioOferta::where('id_usuario', $usuario->id)->where('id_oferta', $id_oferta)->count();
            if ($ofertaActualizar == 0) {
                $usuarioOferta = new UsuarioOferta();
                $usuarioOferta->id_usuario = $usuarioEncontrado->id;
                $usuarioOferta->id_oferta = $id_oferta;
                $usuarioOferta->visitas = 1;
                $usuarioOferta->save();
                //$visitasActualizadas = 1;
            } else {
                $usuarioOfertaActualizar = UsuarioOferta::where('id_usuario', $usuario->id)->where('id_oferta', $id_oferta)->get();
                $visitasActualizadas = $usuarioOfertaActualizar[0]->visitas + 1;
                UsuarioOferta::where('id_usuario', $usuario->id)->where('id_oferta', $id_oferta)->update(['visitas' => $visitasActualizadas]);
            }
        }
        //return json_encode($visitasActualizadas);
    }

    public function obtenerOfertasPorCategoria($num_categoria, $pagina)
    {
        $ofertasTodas = Oferta::get();
        $configNum = Config_recetasOfertas::where('tipo', 1)->get();

        if ($configNum->count() > 0) {
            $mostrar = $configNum->last()->num_recetasPagina;
        } else {
            $mostrar = 12;
        }

        $sizeOfertasTotal = $ofertasTodas->count();
        //$cantOfertas = 20;
        $offset = ($pagina - 1) * $mostrar;
        $listaOfertas = Oferta::where('categoria', $num_categoria);

        if ($listaOfertas->count() != 0) {
            $listaOfertas = Oferta::where('categoria', $num_categoria);
            $sizeOfertas = $listaOfertas->count();
            $ofertas = $listaOfertas->offset($offset)->limit($mostrar)->get();

            return [$ofertas, $sizeOfertas, $mostrar];
        }

        //$ofertas = Oferta::offset($offset)->limit($mostrar)->get();


        return [$ofertasTodas, $sizeOfertasTotal, $mostrar];
    }

    public function ObtenerOfertasMasVisitadas()
    {

        $ofertasVisualizaciones = UsuarioOferta::get();

        $idsOfertas = $ofertasVisualizaciones->groupBy('id_oferta');
        $visitas = 0;
        $arrayVisitasTotales = [];

        foreach ($idsOfertas as $key => $value) {
            $oferta = Oferta::find($key);
            $nombreOferta = $oferta->nombreOferta;
            $visitas = $value->sum('visitas');
            array_push($arrayVisitasTotales, ["id" => $key, "visitas" => $visitas, "nombreOferta" => $nombreOferta]);
        }

        $arrayVisitasTotales = collect($arrayVisitasTotales)->sortByDesc('visitas')->take(5)->values()->all();

        return json_encode($arrayVisitasTotales);
    }
}
