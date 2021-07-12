<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClienteProveedor;
use App\Models\EntidadGO;

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
    }
}
