<?php

namespace App\Exports;

use App\Models\nae;
use App\Models\unidad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UnidadExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'desc',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return unidad::select('desc')->get();
    }
}
