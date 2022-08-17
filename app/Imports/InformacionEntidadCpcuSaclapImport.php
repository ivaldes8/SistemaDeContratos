<?php

namespace App\Imports;

use App\Models\producto;
use App\Models\cpcu;
use App\Models\entidad;
use App\Models\indicador;
use App\Models\informacionEntidadCpcuSaclap;
use App\Models\saclap;
use App\Models\unidad;
use App\Rules\ValidateInformacionClasificador;
use App\Rules\ValidateInformacionIndicador;
use App\Rules\ValidateInformacionEntidad;
use App\Rules\ValidateInformacionProducto;
use App\Rules\ValidateInformacionUnidad;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\Validator;

class InformacionEntidadCpcuSaclapImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $collection = LazyCollection::make($rows);

        //VALIDATION

        Validator::make(
            $collection->toArray(),
            [
                '0.indicador' => ['required', new ValidateInformacionUnidad(), new ValidateInformacionIndicador(), new ValidateInformacionClasificador()],
                '*.producto' => ['required',new ValidateInformacionProducto()],
                '*.entidad' => new ValidateInformacionEntidad(),
            ],
            [
                '*.indicador.required' => 'Tiene que especificar un indicador.',
                '*.producto.required' => 'Hay productos vacíos cerca de: :attribute.',
            ]
        )->validate();

        //VALIDATION

        $datesArray = [];
        foreach ($collection as $key => $row) {
            $datesArray = $row->keys();
        }

        if (count($datesArray) === 0) {
            return back()->withErrors(['msg' => 'No existen columnas dates en el excel']);
        }

        //FORMAT DATES COLUMNS

        $auxArray = [];
        foreach ($datesArray as $key => $date) {
            if (str_contains($date, 'date')) {
                array_push($auxArray, $date);
            }
        }
        $datesArray = $auxArray;



        //STORAGE INDICATORS
        foreach ($collection as  $key => $row) {
            foreach ($datesArray as $date) {
                if ($row[$date]) {
                    $dateFormat = explode('_', $date);
                    if ($key == 0) {
                        $aux = explode('/', $row['indicador']);
                        $indicador = count($aux) > 0 ? $aux[0] : null;
                        $unidad = count($aux) > 1 ? $aux[1] : null;
                        $codigo = count($aux) > 2 ? $aux[2] : null;
                    }

                    $dateOfValues = Carbon::createFromFormat('d-m-Y',  $dateFormat[1] . '-' . $dateFormat[2] . '-' . $dateFormat[3])->format('Y-m-d H:i:s');

                    $data = new informacionEntidadCpcuSaclap();
                    $data->value = $row[$date];
                    $data->date = $dateOfValues;
                    $data->unidad_id = $unidad ? unidad::where('desc', $unidad)->get()[0]->id : null;
                    $data->indicador_id = $indicador ? indicador::where('desc', $indicador)->get()[0]->id : null;
                    $data->cpcu_id = $codigo === 'Cpcu' ? cpcu::where('codigo', $row['producto'])->get()[0]->id : null;
                    $data->saclap_id = $codigo === 'Saclap' ? saclap::where('codigo', $row['producto'])->get()[0]->id : null;
                    if(count(entidad::where('codREU', $row['entidad'])->get()) > 0) {
                        $data->entidad_id = $row['entidad'] ? entidad::where('codREU', $row['entidad'])->get()[0]->id : null;
                    } else if(count(entidad::where('codNIT', $row['entidad'])->get()) > 0){
                        $data->entidad_id = $row['entidad'] ? entidad::where('codNIT', $row['entidad'])->get()[0]->id : null;
                    } else {
                        $data->entidad_id =  null;
                    }

                    $data->save();
                }
            }
        }
    }
}
