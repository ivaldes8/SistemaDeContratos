<?php

namespace Database\Seeders;

use App\Models\EntidadAreaServico;
use App\Models\Servicio;
use Illuminate\Database\Seeder;

class EntidadSA_Table extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a=Servicio::all();
        foreach ($a as $item) {
            EntidadAreaServico::create([
                'idServicioS'=>$item->idservicio
            ]);
        }
    }
}
