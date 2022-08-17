<?php

namespace App\Http\Controllers;

use App\Models\actividad;
use App\Models\indicadorEntidadPlanProducto;
use App\Models\informacionEntidadCpcuSaclap;
use App\Models\producto;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function cuotaDeMercado(Request $request)
    {

        // dd($request->input());
        if (count($request->input()) === 0) {
            $actArr = [];
        } else {
            $validatedData = $request->validate([
                'startDate' => 'required',
                'endDate' => 'required',
                'actividades' => 'required'
            ], [
                'startDate.required' => 'Tiene que especificar una fecha de inicio',
                'endDate.required' => 'Tiene que especificar una fecha final',
                'actividades.required' => 'Tiene que seleccionar al menos una actividad industrial'
            ]);
            $result = 0;
            $query = informacionEntidadCpcuSaclap::query()
                ->whereDate('date', '>=', Carbon::createFromFormat('d/m/Y', request()->input('startDate'))->toDateString())
                ->whereDate('date', '<=', Carbon::createFromFormat('d/m/Y', request()->input('endDate'))->toDateString())
                ->whereHas('cpcu', function ($q) {
                    $q->whereHas('productos', function ($q) {
                        $q->whereHas('actividades', function ($q) {
                            $q->whereIn('actividad_id', request()->input('actividades'));
                        });
                    });
                })->orWhereHas('saclap', function ($q) {
                    $q->whereHas('productos', function ($q) {
                        $q->whereHas('actividades', function ($q) {
                            $q->whereIn('actividad_id', request()->input('actividades'));
                        });
                    });
                })
                // ->with('unidad')
                // ->with('indicador')
                // ->with('cpcu')
                // ->with('saclap')
                // ->with('cpcu.productos')
                ->get();

            //Se crea un array con keys = producto_id, luego cada elemento del array es una array con tres valores [produccion U, importacion U, calculo del indicador U, Npmbre del Producto, id de la actividad Industrial, Actividad Industrial del producto, produccion Valor, importacion Valor, calculo del indicador Valor]
            $productsArray = [];
            for ($i = 0; $i < count($query); $i++) {
                // dd($query[$i]->saclap);
                if ($query[$i]->saclap) {
                    if (count($query[$i]->saclap->productos) > 0){
                        for ($j=0; $j < count($query[$i]->saclap->productos); $j++) {
                            if (!array_search($query[$i]->saclap->productos[$j]->id, $productsArray)) {
                                $productsArray += [$query[$i]->saclap->productos[$j]->id => [0, 0, 0, $query[$i]->saclap->productos[$j]->desc, $query[$i]->saclap->productos[$j]->actividades[0]->id, $query[$i]->saclap->productos[$j]->actividades[0]->desc, 0, 0, 0]];
                            }
                        }
                    }

                }

                if ($query[$i]->cpcu) {
                    if (count($query[$i]->cpcu->productos) > 0){
                        for ($j=0; $j < count($query[$i]->cpcu->productos); $j++) {
                            if (!array_search($query[$i]->cpcu->productos[$j]->id, $productsArray)) {
                                $productsArray += [$query[$i]->cpcu->productos[$j]->id => [0, 0, 0, $query[$i]->cpcu->productos[$j]->desc, $query[$i]->cpcu->productos[$j]->actividades[0]->id, $query[$i]->cpcu->productos[$j]->actividades[0]->desc, 0, 0, 0]];
                            }
                        }
                    }

                }
            }

            // dd($productsArray);

            //Se le da valor a la produccion y a las importaciones de los productos para unidades y valor
            for ($i = 0; $i < count($query); $i++) {

                if ($query[$i]->indicador->codigo === '1' && $query[$i]->unidad->desc === 'U') {

                    if ($query[$i]->cpcu && count($query[$i]->cpcu->productos) > 0){
                        for ($j=0; $j < count($query[$i]->cpcu->productos); $j++) {
                            $productsArray[$query[$i]->cpcu->productos[$j]->id][0] += $query[$i]->value;
                        }
                    }

                    if ($query[$i]->saclap && count($query[$i]->saclap->productos) > 0){
                        for ($j=0; $j < count($query[$i]->saclap->productos); $j++) {
                            $productsArray[$query[$i]->saclap->productos[$j]->id][0] += $query[$i]->value;
                        }
                    }

                    // $productsArray[$query[$i]->producto_id][0] += $query[$i]->value;

                }


                if ($query[$i]->indicador->codigo === '2' && $query[$i]->unidad->desc === 'U') {

                    if ($query[$i]->cpcu && count($query[$i]->cpcu->productos) > 0){
                        for ($j=0; $j < count($query[$i]->cpcu->productos); $j++) {
                            $productsArray[$query[$i]->cpcu->productos[$j]->id][1] += $query[$i]->value;
                        }
                    }

                    if ($query[$i]->saclap && count($query[$i]->saclap->productos) > 0){
                        for ($j=0; $j < count($query[$i]->saclap->productos); $j++) {
                            $productsArray[$query[$i]->saclap->productos[$j]->id][1] += $query[$i]->value;
                        }
                    }

                    //  $productsArray[$query[$i]->producto_id][1] += $query[$i]->value;

                }

                if ($query[$i]->indicador->codigo === '1' && $query[$i]->unidad->desc === 'Valor') {

                    if ($query[$i]->cpcu && count($query[$i]->cpcu->productos) > 0){
                        for ($j=0; $j < count($query[$i]->cpcu->productos); $j++) {
                            $productsArray[$query[$i]->cpcu->productos[$j]->id][6] += $query[$i]->value;
                        }
                    }

                    if ($query[$i]->saclap && count($query[$i]->saclap->productos) > 0){
                        for ($j=0; $j < count($query[$i]->saclap->productos); $j++) {
                            $productsArray[$query[$i]->saclap->productos[$j]->id][6] += $query[$i]->value;
                        }
                    }

                    // $productsArray[$query[$i]->producto_id][6] += $query[$i]->value;

                }

                if ($query[$i]->indicador->codigo === '2' && $query[$i]->unidad->desc === 'Valor') {

                    if ($query[$i]->cpcu && count($query[$i]->cpcu->productos) > 0){
                        for ($j=0; $j < count($query[$i]->cpcu->productos); $j++) {
                            $productsArray[$query[$i]->cpcu->productos[$j]->id][7] += $query[$i]->value;
                        }
                    }

                    if ($query[$i]->saclap && count($query[$i]->saclap->productos) > 0){
                        for ($j=0; $j < count($query[$i]->saclap->productos); $j++) {
                            $productsArray[$query[$i]->saclap->productos[$j]->id][7] += $query[$i]->value;
                        }
                    }
                    // $productsArray[$query[$i]->cpcu->productos[$j]->id][7] += $query[$i]->value;
                }
            }

            //Se calcula el indicador
            foreach ($productsArray as $key => $value) {
                if ($productsArray[$key][0] !== 0 && $productsArray[$key][1] !== 0) {
                    $productsArray[$key][2] = $productsArray[$key][0] / ($productsArray[$key][0] + $productsArray[$key][1]) * 100;
                }
                if ($productsArray[$key][6] !== 0 && $productsArray[$key][7] !== 0) {
                    $productsArray[$key][8] = $productsArray[$key][6] / ($productsArray[$key][6] + $productsArray[$key][7]) * 100;
                }
            }

            //Se agrupa el array de productos por actividades industriales
            $actArr = [];
            foreach ($productsArray as $key => $value) {
                if (!array_search($value[4], $actArr)) {
                    $actArr += [intval($value[4]) => $value[4]];
                }
            }

            //Se prepara el array de actividades para albergar los productos
            foreach ($actArr as $key => $value) {
                $actArr[$key] = [];
            }

            //Se insertan los productos dentro de respectiva actividad
            foreach ($productsArray as $keyProd => $product) {
                foreach ($actArr as $keyAct => $act) {
                    if($product[4] === $keyAct){
                       array_push($actArr[$keyAct],$product);
                    }
                }
            }
        }

        $actividad = actividad::all();
        return view('reportes.cuota', compact('actividad', 'actArr'));
    }
}
