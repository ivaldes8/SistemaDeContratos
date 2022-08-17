<?php

namespace App\Exports;

use App\Models\producto;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class ProductoExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithCustomValueBinder
{

    public function bindValue(Cell $cell, $value)
    {
        if (is_numeric($value)) {
            $cell->setValueExplicit($value, DataType::TYPE_STRING);
            return true;
        }

        // else return default behavior
        return parent::bindValue($cell, $value);
    }

    public function headings(): array
    {
        return [
            'cpcu',
            'saclap',
            'producto',
            'actividadesIndustriales'
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $productos = producto::all();
        $aux = [];
        foreach ($productos as $key => $producto) {
            $implodedSaclap = null;
            $implodedCPCU = null;
            $implodedAct = null;

            if(count($producto->actividades) > 0) {
                $actArr = [];
                foreach ($producto->actividades as $key => $actividad) {
                    array_push($actArr, $actividad->codigo);
                }
                $implodedAct = implode(",", $actArr);
            }

            if(count($producto->saclaps) > 0) {
                $saclapArr = [];
                foreach ($producto->saclaps as $key => $saclap) {
                    array_push($saclapArr, $saclap->codigo);
                }
                $implodedSaclap = implode(",", $saclapArr);
            }

            if(count($producto->cpcus) > 0) {
                $cpcuArr = [];
                foreach ($producto->cpcus as $key => $cpcu) {
                    array_push($cpcuArr, $cpcu->codigo);
                }
                $implodedCPCU = implode(",", $cpcuArr);
            }
            array_push($aux, [$implodedCPCU, $implodedSaclap, $producto->desc, $implodedAct]);
        }
        return collect($aux);
    }
}
