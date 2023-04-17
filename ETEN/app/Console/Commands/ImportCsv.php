<?php

namespace App\Console\Commands;

use App\Models\Oferta;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ImportCsv extends Command
{
    protected $signature = 'import:csv';

    protected $description = 'Importar ofertas desde archivo CSV';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $csvFile = base_path('ofertas/ofertas_concatenadas.csv');
        $csv = Reader::createFromPath($csvFile, 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        DB::beginTransaction();

        try {
            foreach ($records as $record) {
                $data = new Oferta();
                $data->titulo = $record['titulo'];
                $data->price = $record['price'];
                $data->price_less = $record['price_less'];
                $data->url_img = $record['url_img'];
                $data->url = $record['url'];
                $data->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->error('Error al importar el CSV: ' . $e->getMessage());
            return;
        }

        $this->info('CSV importado correctamente!');
    }
}
