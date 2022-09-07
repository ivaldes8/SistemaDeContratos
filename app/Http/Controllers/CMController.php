<?php

namespace App\Http\Controllers;

use App\Exports\CMExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\CM;
use App\Models\CMFile;
use App\Models\Entidad;
use App\Models\entidadClientProvider;
use App\Models\estadoCM;
use App\Models\Grupo;
use App\Models\Logs;
use App\Models\Organismo;
use App\Models\tipoCM;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->input('excel') && $request->input('excel') === 'true') {
            return $this->exportExcel($request);
        }

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

        $cm = $query->orderBy('id', 'desc')->paginate(50);
        $organismos = Organismo::where('activo', 1)->get();
        $grupos = Grupo::where('activo', 1)->get();
        $clientes = Entidad::whereHas('ClienteProveedor', function ($q) {
            return $q->where('isClient', 1);
        })->get();
        $tipos = tipoCM::all();
        $estados = estadoCM::all();
        $now = Carbon::now();
        return view('cm.index', compact('cm', 'organismos', 'grupos', 'clientes', 'tipos', 'estados', 'now'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cm = 'none';
        $organismos = Organismo::where('activo', 1)->get();
        $grupos = Grupo::where('activo', 1)->get();
        $clientes = Entidad::whereHas('ClienteProveedor', function ($q) {
            return $q->where('isClient', 1);
        })->get();
        $tipos = tipoCM::where('activo', 1)->get();
        $estados = estadoCM::where('activo', 1)->get();
        return view('cm.edit', compact('cm', 'organismos', 'grupos', 'clientes', 'tipos', 'estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tipo_id' => 'required',
            'cliente_id' => 'required',
            'estado_id' => 'required',
            'fechaFirma' => 'required',
            'fechaVenc' => 'required',
            'contacto' => 'required',
            'email' => 'required',
            'recibidoPor' => 'required',
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $last = CM::latest('id')->first();
        if ($last != null) {
            $aux = $last->noContrato;
            $lastArr = explode("/", $aux);
        }
        $newYear = $request->input('fechaFirma');

        if ($last != null && $lastArr[1] == Carbon::createFromFormat('Y-m-d', $newYear)->format('y')) {
            $noContract = $lastArr[0] + 1 . '/' . $lastArr[1];
        } else {
            $noContract = 1 . '/' . Carbon::createFromFormat('Y-m-d', $newYear)->format('y');
        }

        $cm = new CM();
        $cm->noContrato = $noContract;
        $cm->tipo_id = $request->input('tipo_id');
        $cm->entidad_id = entidadClientProvider::where('entidad_id', $request->input('cliente_id'))->get()[0]->id;
        $cm->estado_id = $request->input('estado_id');
        $cm->fechaFirma = Carbon::createFromFormat('Y-m-d', $request->input('fechaFirma'))->toDateString();
        $cm->fechaVenc = Carbon::createFromFormat('Y-m-d', $request->input('fechaVenc'))->toDateString();
        $cm->contacto = $request->input('contacto');
        $cm->email = $request->input('email');
        $cm->recibidoPor = $request->input('recibidoPor');
        $cm->observ = $request->input('observ');
        $cm->user_id = Auth::user()->id;
        $cm->save($validatedData);

        $logCM = new Logs();
        $logCM->user_id = Auth::user()->id;
        $logCM->action = 'create';
        $logCM->element = $cm->id;
        $logCM->type = 'CM';
        $logCM->save();

        $cmf = new CMFile();
        $cmf->cm_id = $cm->id;
        $cmf->save();

        $logCMF = new Logs();
        $logCMF->user_id = Auth::user()->id;
        $logCMF->action = 'create';
        $logCMF->element = $cmf->id;
        $logCMF->type = 'CMF';
        $logCMF->save();

        return redirect('cm')->with('status', 'Contrato Marco añadido satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = CM::query();

        $query->whereHas('cliente', function ($q) use ($id) {
            $q->whereHas('entidad', function ($q) use ($id) {
                return $q->where('identidad', $id);
            });
        });

        $cm = $query->orderBy('id', 'desc')->paginate(50);
        $organismos = Organismo::where('activo', 1)->get();
        $grupos = Grupo::where('activo', 1)->get();
        $clientes = Entidad::whereHas('ClienteProveedor', function ($q) {
            return $q->where('isClient', 1);
        })->get();
        $tipos = tipoCM::all();
        $estados = estadoCM::all();
        $now = Carbon::now();
        return view('cm.index', compact('cm', 'organismos', 'grupos', 'clientes', 'tipos', 'estados', 'now'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cm = CM::find($id);
        $organismos = Organismo::where('activo', 1)->get();
        $grupos = Grupo::where('activo', 1)->get();
        $clientes = Entidad::whereHas('ClienteProveedor', function ($q) {
            return $q->where('isClient', 1);
        })->get();
        $tipos = tipoCM::where('activo', 1)->get();
        $estados = estadoCM::where('activo', 1)->get();
        return view('cm.edit', compact('cm', 'organismos', 'grupos', 'clientes', 'tipos', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'tipo_id' => 'required',
            'cliente_id' => 'required',
            'estado_id' => 'required',
            'fechaFirma' => 'required',
            'fechaVenc' => 'required',
            'contacto' => 'required',
            'email' => 'required',
            'recibidoPor' => 'required',
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $cm = CM::find($id);
        $cm->tipo_id = $request->input('tipo_id');
        $cm->entidad_id = entidadClientProvider::where('entidad_id', $request->input('cliente_id'))->get()[0]->id;
        $cm->estado_id = $request->input('estado_id');
        $cm->fechaFirma = Carbon::createFromFormat('Y-m-d', $request->input('fechaFirma'))->toDateString();
        $cm->fechaVenc = Carbon::createFromFormat('Y-m-d', $request->input('fechaVenc'))->toDateString();
        $cm->contacto = $request->input('contacto');
        $cm->email = $request->input('email');
        $cm->recibidoPor = $request->input('recibidoPor');
        $cm->observ = $request->input('observ');
        $cm->update($validatedData);

        $logCM = new Logs();
        $logCM->user_id = Auth::user()->id;
        $logCM->action = 'edit';
        $logCM->element = $cm->id;
        $logCM->type = 'CM';
        $logCM->save();

        $year = explode("/", $cm->noContrato);
        if ($request->hasFile('file1')) {
            $file1 = $request->file('file1');
            $destinationPath = 'ContratosMarco/' . $year[1] . '/' .  $year[0] . '-' . $year[1];
            $file1Name = '1-' . $year[0] . '-' . $year[1] . "." . $file1->getClientOriginalExtension();
            $file1->move(storage_path('app/public/' . $destinationPath), $file1Name);
            $cm->file->file1 = $file1Name;
        }
        if ($request->hasFile('file2')) {
            $file2 = $request->file('file2');
            $destinationPath = 'ContratosMarco/' . $year[1] . '/' .  $year[0] . '-' . $year[1]; //'1-' . $CM->noContrato .
            $file2Name = '2-' . $year[0] . '-' . $year[1] . "." . $file2->getClientOriginalExtension();
            $file2->move(storage_path('app/public/' . $destinationPath), $file2Name);
            $cm->file->file2 = $file2Name;
        }
        if ($request->hasFile('file3')) {
            $file3 = $request->file('file3');
            $destinationPath = 'ContratosMarco/' . $year[1] . '/' .  $year[0] . '-' . $year[1]; //'1-' . $CM->noContrato .
            $file3Name = '3-' . $year[0] . '-' . $year[1] . "." . $file3->getClientOriginalExtension();
            $file3->move(storage_path('app/public/' . $destinationPath), $file3Name);
            $cm->file->file3 = $file3Name;
        }
        if ($request->hasFile('file4')) {
            $file4 = $request->file('file4');
            $destinationPath = 'ContratosMarco/' . $year[1] . '/' .  $year[0] . '-' . $year[1]; //'1-' . $CM->noContrato .
            $file4Name = '4-' . $year[0] . '-' . $year[1] . "." . $file4->getClientOriginalExtension();
            $file4->move(storage_path('app/public/' . $destinationPath), $file4Name);
            $cm->file->file4 = $file4Name;
        }
        if ($request->hasFile('file1') || $request->hasFile('file2') || $request->hasFile('file3') || $request->hasFile('file4')) {
            $cm->file->path = $destinationPath;
            $cm->file->update();

            $logCMF = new Logs();
            $logCMF->user_id = Auth::user()->id;
            $logCMF->action = 'edit';
            $logCMF->element = $cm->file->id;
            $logCMF->type = 'CMF';
            $logCMF->save();
        }

        return redirect('cm')->with('status', 'Contrato Marco editado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(new CMExport($request), 'cm.xlsx');
    }
}
