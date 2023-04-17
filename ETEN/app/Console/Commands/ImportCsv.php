<?php

namespace App\Console\Commands;

use App\Models\Oferta;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ImportCsv extends Command
{
    protected $signature = 'import:csv';

    protected $description = 'Importar ofertas desde archivo CSV concatenado';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
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

        $this->info('Archivo CSV importado exitosamente.');
    }
}
