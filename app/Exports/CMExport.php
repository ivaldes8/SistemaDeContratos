<?php

namespace App\Exports;

use App\Models\CM;
use App\Models\nae;
use App\Models\unidad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CMExport implements FromCollection, WithHeadings
{

    use Exportable;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function headings(): array
    {
        return [
            'No. Contrato',
            'Cod. Interno',
            'Cod. REU',
            'Cliente',
            'Siglas',
            'Organismo',
            'Grupo',
            'Tipo',
            'Estado',
            'Fecha de firma',
            'Fecha de Vencimiento',
            'Observaciones'
        ];
    }

    public function collection()
    {
        $query = CM::query();

        $query->when(request()->input('noContrato'), function ($q) {
            return $q->where('noContrato', request()->input('noContrato'));
        });

        $query->when(request()->input('codigo'), function ($q) {
            $q->whereHas('cliente', function ($q) {
                $q->whereHas('entidad', function ($q) {
                    return $q->where('codigo', 'like', '%' . request()->input('codigo') . '%');
                });
            });
        });

        $query->when(request()->input('codigoreu'), function ($q) {
            $q->whereHas('cliente', function ($q) {
                $q->whereHas('entidad', function ($q) {
                    return $q->where('codigoreu', 'like', '%' . request()->input('codigoreu') . '%');
                });
            });
        });

        $query->when(request()->input('tipo_id'), function ($q) {
            return $q->where('tipo_id', request()->input('tipo_id'));
        });

        $query->when(request()->input('estado_id'), function ($q) {
            return $q->where('estado_id', request()->input('estado_id'));
        });


        if (request()->input('org_id') && request()->input('org_id') !== '@') {
            $query->when(request()->input('org_id'), function ($q) {
                $q->whereHas('cliente', function ($q) {
                    $q->whereHas('entidad', function ($q) {
                        $q->whereHas('GrupoOrgnanismo', function ($q) {
                            $q->whereHas('organismo', function ($q) {
                                return $q->where('org_id', request()->input('org_id'));
                            });
                        });
                    });
                });
            });
        }

        if (request()->input('grupo_id') && request()->input('grupo_id') !== '@') {
            $query->when(request()->input('grupo_id'), function ($q) {
                $q->whereHas('cliente', function ($q) {
                    $q->whereHas('entidad', function ($q) {
                        $q->whereHas('GrupoOrgnanismo', function ($q) {
                            $q->whereHas('grupo', function ($q) {
                                return $q->where('grupo_id', request()->input('grupo_id'));
                            });
                        });
                    });
                });
            });
        }

        if (request()->input('cliente_id') && request()->input('cliente_id') !== '@') {
            $query->when(request()->input('cliente_id'), function ($q) {
                $q->whereHas('cliente', function ($q) {
                    $q->whereHas('entidad', function ($q) {
                        return $q->where('identidad', request()->input('cliente_id'));
                    });
                });
            });
        }

        $query->when(request()->input('fechaIniFrom'), function ($q) {
            return $q->whereDate('fechaFirma', '>=', Carbon::createFromFormat('d/m/Y', request()->input('fechaIniFrom'))->toDateString());
        });

        $query->when(request()->input('fechaIniTo'), function ($q) {
            return $q->whereDate('fechaFirma', '<=', Carbon::createFromFormat('d/m/Y', request()->input('fechaIniTo'))->toDateString());
        });

        $query->when(request()->input('fechaEndFrom'), function ($q) {
            return $q->whereDate('fechaVenc', '<=', Carbon::createFromFormat('d/m/Y', request()->input('fechaEndFrom'))->toDateString());
        });

        $query->when(request()->input('fechaEndTo'), function ($q) {
            return $q->whereDate('fechaVenc', '>=', Carbon::createFromFormat('d/m/Y', request()->input('fechaEndTo'))->toDateString());
        });

        $cm = $query->orderBy('id', 'desc')->get();

        $aux = [];

        foreach ($cm as $key => $contrato) {
            array_push($aux, [
                $contrato->noContrato,
                $contrato->cliente && $contrato->cliente->entidad ? $contrato->cliente->entidad->codigo : '---',
                $contrato->cliente && $contrato->cliente->entidad ? $contrato->cliente->entidad->codigoreu : '---',
                $contrato->cliente && $contrato->cliente->entidad ? $contrato->cliente->entidad->nombre : '---',
                $contrato->cliente && $contrato->cliente->entidad ? $contrato->cliente->entidad->abreviatura : '---',
                $contrato->cliente && $contrato->cliente->entidad && $contrato->cliente->entidad->GrupoOrgnanismo && $contrato->cliente->entidad->GrupoOrgnanismo->organismo ? $contrato->cliente->entidad->GrupoOrgnanismo->organismo->nombre : '---',
                $contrato->cliente && $contrato->cliente->entidad && $contrato->cliente->entidad->GrupoOrgnanismo && $contrato->cliente->entidad->GrupoOrgnanismo->grupo ? $contrato->cliente->entidad->GrupoOrgnanismo->grupo->nombre : '---',
                $contrato->tipo ? $contrato->tipo->nombre : '---',
                $contrato->estado ? $contrato->estado->nombre : '---',
                $contrato->fechaFirma,
                $contrato->fechaVenc,
                $contrato->observ ? $contrato->observ : '---'
            ]);
        }
        return collect($aux);
    }
}
