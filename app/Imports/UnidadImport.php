<?php

namespace App\Imports;

use App\Models\unidad;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Validator;

class UnidadImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // dd($rows);
        $collection = LazyCollection::make($rows);


        Validator::make($collection->toArray(), [
            '*.desc' => 'required|unique:unidads'
        ],
        [
            '*.desc.unique' => 'La unidad :input ya se encuentra en la base de datos',
            '*.desc.required' => 'Hay descripciones vacías cerca de: :attribute'
        ])->validate();

        foreach ($collection as $row) {
            unidad::create([
                'desc' => $row['desc']
            ]);
        }
    }
}
