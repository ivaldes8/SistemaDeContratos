<?php

namespace App\Exports;

use App\Models\entidad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class EntidadExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithCustomValueBinder
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
            'nombre',
            'codreu',
            'codnit',
            'siglas',
            'direccion',
            'dpa',
            'codFormOrg',
            'formOrg',
            'codorganismo',
            'codosde'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $entidades = entidad::all();
        $aux = [];
        foreach ($entidades as $key => $entidad) {
            array_push($aux,[$entidad->name, $entidad->codREU, $entidad->codNIT, $entidad->siglas, $entidad->direccion, $entidad->dpa, $entidad->codFormOrg, $entidad->formOrg, $entidad->organismo->codigo, $entidad->osde->codigo]);
        }

        return collect($aux);
    }
}
