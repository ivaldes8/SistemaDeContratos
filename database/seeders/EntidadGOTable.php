<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClienteProveedor;
use App\Models\EntidadGO;
use App\Models\Grupo;
use App\Models\Organismo;

class EntidadGOTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a=ClienteProveedor::all();
        foreach ($a as $item) {
            EntidadGO::create([
                'idClientGO'=>$item->identidad,
                'idOrganismo'=>'1',
                'idGrupo'=>'1'
            ]);
        }

        Grupo::create([
            'codigoG' => '0',
            'nombreG' => 'Grupo no seleccionado',
            'id_Organismo' => '1',
            'siglasG' => 'NoGrup'
        ]);

        Organismo::create([
            'codigoO' => '0',
            'nombreO' => 'Organismo no seleccionado',
            'siglasO' => 'NoOrg',
        ]);
    }
}
