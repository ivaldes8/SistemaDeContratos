<?php

namespace App\Http\Controllers;

use App\Models\CP;
use App\Models\Logs;
use App\Models\CPFile;
use App\Models\Entidad;
use App\Models\entidadClientProvider;
use App\Models\estadoCP;
use App\Models\Grupo;
use App\Models\Organismo;
use App\Models\tipoCP;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = CP::query();

        $query->when(request()->input('noContrato'), function ($q) {
            return $q->where('noContrato', request()->input('noContrato'));
        });

        $query->when(request()->input('codigo'), function ($q) {
            $q->whereHas('proveedor', function ($q) {
                $q->whereHas('entidad', function ($q) {
                    return $q->where('codigo', 'like', '%' . request()->input('codigo') . '%');
                });
            });
        });

        $query->when(request()->input('codigoreu'), function ($q) {
            $q->whereHas('proveedor', function ($q) {
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
                $q->whereHas('proveedor', function ($q) {
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
                $q->whereHas('proveedor', function ($q) {
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

        if (request()->input('proveedor_id') && request()->input('proveedor_id') !== '@') {
            $query->when(request()->input('proveedor_id'), function ($q) {
                $q->whereHas('proveedor', function ($q) {
                    $q->whereHas('entidad', function ($q) {
                        return $q->where('identidad', request()->input('proveedor_id'));
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

        $cp = $query->orderBy('id', 'desc')->paginate(50);
        $organismos = Organismo::where('activo', 1)->get();
        $grupos = Grupo::where('activo', 1)->get();
        $proveedores = Entidad::whereHas('ClienteProveedor', function ($q) {
            return $q->where('isProvider', 1);
        })->get();
        $tipos = tipoCP::all();
        $estados = estadoCP::all();
        $now = Carbon::now();
        return view('cp.index', compact('cp', 'organismos', 'grupos', 'proveedores', 'tipos', 'estados', 'now'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cp = 'none';
        $organismos = Organismo::where('activo', 1)->get();
        $grupos = Grupo::where('activo', 1)->get();
        $proveedores = Entidad::whereHas('ClienteProveedor', function ($q) {
            return $q->where('isProvider', 1);
        })->get();
        $tipos = tipoCP::where('activo', 1)->get();
        $estados = estadoCP::where('activo', 1)->get();
        return view('cp.edit', compact('cp', 'organismos', 'grupos', 'proveedores', 'tipos', 'estados'));
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
            'noContrato' => 'required',
            'tipo_id' => 'required',
            'proveedor_id' => 'required',
            'estado_id' => 'required',
            'fechaFirma' => 'required',
            'fechaVenc' => 'required',
            'contacto' => 'required',
            'email' => 'required',
            'recibidoPor' => 'required',
        ], [
            'required' => 'Este campo es requerido'
        ]);


        $cp = new CP();
        $cp->noContrato = $request->input('noContrato');;
        $cp->tipo_id = $request->input('tipo_id');
        $cp->entidad_id = entidadClientProvider::where('entidad_id', $request->input('proveedor_id'))->get()[0]->id;
        $cp->estado_id = $request->input('estado_id');
        $cp->fechaFirma = Carbon::createFromFormat('Y-m-d', $request->input('fechaFirma'))->toDateString();
        $cp->fechaVenc = Carbon::createFromFormat('Y-m-d', $request->input('fechaVenc'))->toDateString();
        $cp->contacto = $request->input('contacto');
        $cp->email = $request->input('email');
        $cp->recibidoPor = $request->input('recibidoPor');
        $cp->observ = $request->input('observ');
        $cp->monto = $request->input('monto');
        $cp->user_id = Auth::user()->id;
        $cp->save($validatedData);

        $logCP = new Logs();
        $logCP->user_id = Auth::user()->id;
        $logCP->action = 'create';
        $logCP->element = $cp->id;
        $logCP->type = 'CP';
        $logCP->save();

        $cpf = new CPFile();
        $cpf->cp_id = $cp->id;
        $cpf->save();

        $logCPF = new Logs();
        $logCPF->user_id = Auth::user()->id;
        $logCPF->action = 'create';
        $logCPF->element = $cpf->id;
        $logCPF->type = 'CPF';
        $logCPF->save();

        return redirect('cp')->with('status', 'Contrato añadido satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = CP::query();

        $query->whereHas('proveedor', function ($q) use ($id) {
            $q->whereHas('entidad', function ($q) use ($id) {
                return $q->where('identidad', $id);
            });
        });

        $cp = $query->orderBy('id', 'desc')->paginate(50);
        $organismos = Organismo::where('activo', 1)->get();
        $grupos = Grupo::where('activo', 1)->get();
        $proveedores = Entidad::whereHas('ClienteProveedor', function ($q) {
            return $q->where('isProvider', 1);
        })->get();
        $tipos = tipoCP::all();
        $estados = estadoCP::all();
        $now = Carbon::now();
        return view('cp.index', compact('cp', 'organismos', 'grupos', 'proveedores', 'tipos', 'estados', 'now'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cp = CP::find($id);
        $organismos = Organismo::where('activo', 1)->get();
        $grupos = Grupo::where('activo', 1)->get();
        $proveedores = Entidad::whereHas('ClienteProveedor', function ($q) {
            return $q->where('isProvider', 1);
        })->get();
        $tipos = tipoCP::where('activo', 1)->get();
        $estados = estadoCP::where('activo', 1)->get();
        return view('cp.edit', compact('cp', 'organismos', 'grupos', 'proveedores', 'tipos', 'estados'));
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
            'noContrato' => 'required',
            'tipo_id' => 'required',
            'proveedor_id' => 'required',
            'estado_id' => 'required',
            'fechaFirma' => 'required',
            'fechaVenc' => 'required',
            'contacto' => 'required',
            'email' => 'required',
            'recibidoPor' => 'required',
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $cp = CP::find($id);
        $cp->tipo_id = $request->input('tipo_id');
        $cp->entidad_id = entidadClientProvider::where('entidad_id', $request->input('proveedor_id'))->get()[0]->id;
        $cp->estado_id = $request->input('estado_id');
        $cp->fechaFirma = Carbon::createFromFormat('Y-m-d', $request->input('fechaFirma'))->toDateString();
        $cp->fechaVenc = Carbon::createFromFormat('Y-m-d', $request->input('fechaVenc'))->toDateString();
        $cp->contacto = $request->input('contacto');
        $cp->email = $request->input('email');
        $cp->recibidoPor = $request->input('recibidoPor');
        $cp->observ = $request->input('observ');
        $cp->noContrato = $request->input('noContrato');
        $cp->update($validatedData);

        $logCP = new Logs();
        $logCP->user_id = Auth::user()->id;
        $logCP->action = 'edit';
        $logCP->element = $cp->id;
        $logCP->type = 'CP';
        $logCP->save();

        $year = explode("/", $cp->noContrato);
        if ($request->hasFile('file1')) {
            $file1 = $request->file('file1');
            $destinationPath = 'ContratosProveedor/' . $year[1] . '/' .  $year[0] . '-' . $year[1];
            $file1Name = '1-' . $year[0] . '-' . $year[1] . "." . $file1->getClientOriginalExtension();
            $file1->move(storage_path('app/public/' . $destinationPath), $file1Name);
            $cp->file->file1 = $file1Name;
        }
        if ($request->hasFile('file2')) {
            $file2 = $request->file('file2');
            $destinationPath = 'ContratosProveedor/' . $year[1] . '/' .  $year[0] . '-' . $year[1]; //'1-' . $CM->noContrato .
            $file2Name = '2-' . $year[0] . '-' . $year[1] . "." . $file2->getClientOriginalExtension();
            $file2->move(storage_path('app/public/' . $destinationPath), $file2Name);
            $cp->file->file2 = $file2Name;
        }
        if ($request->hasFile('file3')) {
            $file3 = $request->file('file3');
            $destinationPath = 'ContratosProveedor/' . $year[1] . '/' .  $year[0] . '-' . $year[1]; //'1-' . $CM->noContrato .
            $file3Name = '3-' . $year[0] . '-' . $year[1] . "." . $file3->getClientOriginalExtension();
            $file3->move(storage_path('app/public/' . $destinationPath), $file3Name);
            $cp->file->file3 = $file3Name;
        }
        if ($request->hasFile('file4')) {
            $file4 = $request->file('file4');
            $destinationPath = 'ContratosProveedor/' . $year[1] . '/' .  $year[0] . '-' . $year[1]; //'1-' . $CM->noContrato .
            $file4Name = '4-' . $year[0] . '-' . $year[1] . "." . $file4->getClientOriginalExtension();
            $file4->move(storage_path('app/public/' . $destinationPath), $file4Name);
            $cp->file->file4 = $file4Name;
        }
        if ($request->hasFile('file1') || $request->hasFile('file2') || $request->hasFile('file3') || $request->hasFile('file4')) {
            $cp->file->path = $destinationPath;
            $cp->file->update();

            $logCP = new Logs();
            $logCP->user_id = Auth::user()->id;
            $logCP->action = 'edit';
            $logCP->element = $cp->file->id;
            $logCP->type = 'CPF';
            $logCP->save();
        }

        return redirect('cp')->with('status', 'Contrato editado satisfactoriamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        // dd($id);
        return Storage::download('public/storage/app/public/1.pdf');
    }
}
