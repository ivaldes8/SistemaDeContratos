<?php

namespace App\Imports;

use App\Models\actividad;
use App\Models\producto;
use App\Models\cpcu;
use App\Models\saclap;
use App\Rules\ValidateSACLAPProducto;
use App\Rules\ValidateActividadesProducto;
use App\Rules\ValidateCPCUProducto;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Validator;

class ProductoImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $collection = LazyCollection::make($rows);

        Validator::make($collection->toArray(), [
            '*.producto' => 'required|unique:productos,desc',
            '*.cpcu' => ['required',new ValidateCPCUProducto()],
            '*.saclap' => ['required',new ValidateSACLAPProducto()],
            '*.actividadesindustriales' => [new ValidateActividadesProducto()],
        ],
        [
            '*.producto.required' => 'Hay productos vacíos cerca de: :attribute',
            '*.producto.unique' => 'El producto :input ya se encuentra en la base de datos',
            '*.cpcu.required' => 'Hay cpcus vacíos cerca de: :attribute',
            '*.cpcu.exists' => 'No existen cpcus con el código: :input cerca de: :attribute ',
            '*.saclap.required' => 'Hay saclaps vacíos cerca de: :attribute',
            '*.saclap.exists' => 'No existen saclaps con el código: :input cerca de: :attribute ',
        ])->validate();

        foreach ($collection as $row) {
            $producto = new producto();
            $producto->desc = $row['producto'];
            $producto->save();

            if($row['cpcu']){
                $cpcus = explode( ',', $row['cpcu'] );
                $cpcusId = [];
                if(count($cpcus) > 0){
                    for ($i=0; $i < count($cpcus); $i++) {
                        array_push($cpcusId,cpcu::where('codigo', $cpcus[$i])->get()[0]->id);
                    }
                }

                $producto->cpcus()->attach($cpcusId);
            }

            if($row['saclap']){
                $saclaps = explode( ',', $row['saclap'] );
                $saclapsId = [];
                for ($i=0; $i < count($saclaps); $i++) {
                    array_push($saclapsId,saclap::where('codigo', $saclaps[$i])->get()[0]->id);
                }
                $producto->saclaps()->attach($saclapsId);
            }

            if($row['actividadesindustriales']){
                $actividades = explode( '/', $row['actividadesindustriales'] );
                $actividadesId = [];
                for ($i=0; $i < count($actividades); $i++) {
                    array_push($actividadesId,actividad::where('codigo', $actividades[$i])->get()[0]->id);
                }
                $producto->actividades()->attach($actividadesId);
            }

        }
    }

}
