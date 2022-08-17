<?php

namespace App\Imports;

use App\Models\organismo;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Validator;

class OrganismoImport implements ToCollection, WithHeadingRow
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
            '*.codigo' => 'required|unique:organismos',
            '*.nombre' => 'required'

        ],
        [
            '*.codigo.unique' => 'El código :input ya se encuentra en la base de datos',
            '*.codigo.required' => 'Hay códigos vacíos cerca de: :attribute',
            '*.codigo.required' => 'Hay códigos vacíos cerca de: :attribute',
            '*.nombre.required' => 'Hay nombres vacíos cerca de: :attribute'
        ])->validate();

        foreach ($collection as $row) {
            organismo::create([
                'codigo' => $row['codigo'],
                'name' => $row['nombre'],
                'siglas' => $row['siglas']
            ]);
        }
    }
}
