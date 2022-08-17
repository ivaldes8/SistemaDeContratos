<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class InformacionExport extends DefaultValueBinder implements FromCollection, WithHeadings, WithCustomValueBinder
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
            'indicador',
            'producto',
            'entidad',
            'date1->31-01-2022',
            'date2->28-02-2022',
            'date3->31-03-2022'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $aux = [0 => ['Importaciones/U/Saclap', '32131.0100', '5469', '40', '500', '320']];
        return collect($aux);
    }
}
