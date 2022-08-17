<?php

namespace App\Imports;

use App\Models\osde;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Validator;

class OSDEImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        // dd($rows);
        $collection = LazyCollection::make($rows);


        Validator::make($collection->toArray(), [
            '*.codigo' => 'required|unique:osdes',
            '*.nombre' => 'required'

        ],
        [
            '*.codigo.unique' => 'El código :input ya se encuentra en la base de datos',
            '*.codigo.required' => 'Hay códigos vacíos cerca de: :attribute',
            '*.codigo.required' => 'Hay códigos vacíos cerca de: :attribute',
            '*.nombre.required' => 'Hay nombres vacíos cerca de: :attribute'
        ])->validate();

        foreach ($collection as $row) {
            osde::create([
                'codigo' => $row['codigo'],
                'name' => $row['nombre'],
                'siglas' => $row['siglas']
            ]);
        }
    }

}
