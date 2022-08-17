<?php
  
namespace App\Imports;

use App\Models\cpcu;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Validator;
  
class CPCUImport implements ToCollection, WithHeadingRow
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
            '*.codigo' => 'required|unique:cpcus',
            '*.desc' => 'required'
        ],
        [
            '*.codigo.unique' => 'El código :input ya se encuentra en la base de datos',
            '*.codigo.required' => 'El códigos vacíos en el excel cerca de: :attribute',
            '*.desc.required' => 'Hay descripciones vacías cerca de: :attribute'
        ])->validate();

        foreach ($collection as $row) {
            cpcu::create([
                'codigo' => $row['codigo'],
                'desc' => $row['desc']
            ]);
        }
    }
  
}