<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OSDEExport;
use App\Models\Entidad;
use App\Models\entidadClientProvider;
use App\Models\entidadGrupoOrganismo;
use App\Models\Organismo;

class GrupoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Grupo::query();

        $query->when(request()->input('codigo'), function ($q) {
            return $q->where('codigo', 'like', '%' . request()->input('codigo') . '%');
        });

        $query->when(request()->input('nombre'), function ($q) {
            return $q->where('nombre', 'like', '%' . request()->input('nombre') . '%');
        });

        $query->when(request()->input('siglas'), function ($q) {
            return $q->where('siglas', 'like', '%' . request()->input('siglas') . '%');
        });

        $query->when(request()->input('org_id'), function ($q) {
            $q->where('org_id', request()->input('org_id'));
        });

        $grupo = $query->paginate(10);
        $organismos = Organismo::where('activo', 1)->get();

        return view('grupo.index', compact('grupo', 'organismos'));
    }

    public function getGrupoByOrganismo(Request $request)
    {
        $grupos = Grupo::where("org_id", $request->org_id)->pluck("nombre", "id");
        return response()->json($grupos);
    }


    public function getClientByOrganismo(Request $request)
    {
        $query = entidadClientProvider::query();

        $query->where('isClient', 1);

        $query->whereHas('entidad', function ($q) {
            $q->whereHas('GrupoOrgnanismo', function ($q) {
                $q->whereHas('organismo', function ($q) {
                    return $q->where('org_id', request()->input('org_id'));
                });
            });
        });

        $clientes = $query->join("dbo.EntidadesView", 'dbo.EntidadesView.identidad', '=', 'entidad_id')->pluck("nombre", "identidad");
        return response()->json($clientes);
    }

    public function getClientByGrupo(Request $request)
    {
        $query = entidadClientProvider::query();

        $query->where('isClient', 1);

        $query->whereHas('entidad', function ($q) {
            $q->whereHas('GrupoOrgnanismo', function ($q) {
                $q->whereHas('grupo', function ($q) {
                    return $q->where('grupo_id', request()->input('grupo_id'));
                });
            });
        });

        $clientes = $query->join("dbo.EntidadesView", 'dbo.EntidadesView.identidad', '=', 'entidad_id')->pluck("nombre", "identidad");
        return response()->json($clientes);
    }

    public function getProviderByOrganismo(Request $request)
    {
        $query = entidadClientProvider::query();

        $query->where('isProvider', 1);

        $query->whereHas('entidad', function ($q) {
            $q->whereHas('GrupoOrgnanismo', function ($q) {
                $q->whereHas('organismo', function ($q) {
                    return $q->where('org_id', request()->input('org_id'));
                });
            });
        });

        $proveedores = $query->join("dbo.EntidadesView", 'dbo.EntidadesView.identidad', '=', 'entidad_id')->pluck("nombre", "identidad");
        return response()->json($proveedores);
    }

    public function getProviderByGrupo(Request $request)
    {
        $query = entidadClientProvider::query();

        $query->where('isProvider', 1);

        $query->whereHas('entidad', function ($q) {
            $q->whereHas('GrupoOrgnanismo', function ($q) {
                $q->whereHas('grupo', function ($q) {
                    return $q->where('grupo_id', request()->input('grupo_id'));
                });
            });
        });

        $proveedores = $query->join("dbo.EntidadesView", 'dbo.EntidadesView.identidad', '=', 'entidad_id')->pluck("nombre", "identidad");
        return response()->json($proveedores);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grupo = 'none';
        $organismos = Organismo::where('activo', 1)->get();
        return view('grupo.edit', compact('grupo', 'organismos'));
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
            'nombre' => 'required',
            'codigo' => 'required',
            'siglas' => 'required',
            'org_id' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $grupo = new Grupo();
        $grupo->nombre = $request->input('nombre');
        $grupo->siglas = $request->input('siglas');
        $grupo->codigo = $request->input('codigo');
        $grupo->activo = $request->input('activo') ? 1 : 0;
        $grupo->org_id = $request->input('org_id');
        $grupo->save($validatedData);
        return redirect('/grupo')->with('status', 'Grupo creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grupo = Grupo::find($id);
        $organismos = Organismo::where('activo', 1)->get();
        return view('grupo.edit', compact('grupo', 'organismos'));
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
            'nombre' => 'required',
            'codigo' => 'required',
            'siglas' => 'required',
            'org_id' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $grupo = Grupo::find($id);
        $grupo->nombre = $request->input('nombre');
        $grupo->siglas = $request->input('siglas');
        $grupo->codigo = $request->input('codigo');
        $grupo->activo = $request->input('activo') ? 1 : 0;
        $grupo->org_id = $request->input('org_id');
        $grupo->update($validatedData);
        return redirect('/grupo')->with('status', 'Grupo Editado satisfactoriamente');
    }

    public function delete($id)
    {
        $grupo = Grupo::find($id);
        return view('grupo.delete', compact('grupo'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grupo = Grupo::find($id);
        $grupo->delete();
        return redirect()->back()->with('status', 'Grupo eliminado Satisfactoriamente');
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function export()
    {
        return Excel::download(new OSDEExport, 'osdes.xlsx');
    }
}
