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
                'idClient'=>$item->identidad,
                'idOrganismo'=>'1',
                'idGrupo'=>'1'
            ]);
        }

        Grupo::create([
            'codigo' => '0',
            'nombre' => 'Grupo no seleccionado',
            'id_Organismo' => '1',
            'siglas' => 'NoGrup'
        ]);

        Organismo::create([
            'codigo' => '0',
            'nombre' => 'Organismo no seleccionado',
            'siglas' => 'NoOrg',
        ]);
    }
}
