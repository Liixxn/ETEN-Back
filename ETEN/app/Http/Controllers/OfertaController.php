<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Oferta;

use Illuminate\Support\Facades\Storage;


class OfertaController extends Controller
{
    public function ObtenerOfertas()
    {
        $oferta = Oferta::getAll();
        return "Receta: $oferta";
    }

    public function importCsv()
    {
        $csvFilePath = storage_path('app/public/ofertas_concatenadas.csv');
        $csvData = file_get_contents($csvFilePath);

        $rows = array_map('str_getcsv', explode("\n", $csvData));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            if (count($row) === count($header)) {
                $ofertaData = array_combine($header, $row);
                Oferta::create($ofertaData);
            }
        }

        return redirect()->back()->with('success', 'Archivo CSV importado exitosamente.');
    }
}
