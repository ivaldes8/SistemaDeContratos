<?php

namespace App\Imports;

use App\Models\actividad;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Validator;

class ActividadIndustrialImport implements ToCollection, WithHeadingRow
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
            '*.codigo' => 'required|unique:actividads',
            '*.desc' => 'required|unique:actividads',
        ],
        [
            '*.codigo.unique' => 'El código :input ya se encuentra en la base de datos',
            '*.codigo.required' => 'Hay códigos vacíos cerca de: :attribute',
            '*.desc.unique' => 'La descripción :input ya se encuentra en la base de datos',
            '*.desc.required' => 'Hay descripciones vacías cerca de: :attribute'
        ])->validate();

        foreach ($collection as $row) {
            actividad::create([
                'codigo' => $row['codigo'],
                'desc' => $row['desc']
            ]);
        }
    }
}
