<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClienteProveedor;
use App\Models\EntidadCP;

class CP_table extends Seeder
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
            EntidadCP::create([
                'idClient'=>$item->identidad,
                'cliente'=>'false',
                'proveedor'=>'false'
            ]);
        }
    }
}
