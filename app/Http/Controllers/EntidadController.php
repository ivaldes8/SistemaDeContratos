<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\entidadClientProvider;
use App\Models\entidadGrupoOrganismo;
use App\Models\Grupo;
use App\Models\Organismo;
use Illuminate\Http\Request;

class EntidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Entidad::query();

        $query->when(request()->input('codigoreu'), function ($q) {
            return $q->where('codigoreu', 'like', '%' . request()->input('codigoreu') . '%');
        });

        $query->when(request()->input('nombre'), function ($q) {
            return $q->where('nombre', 'like', '%' . request()->input('nombre') . '%');
        });

        $query->when(request()->input('abreviatura'), function ($q) {
            return $q->where('abreviatura', 'like', '%' . request()->input('abreviatura') . '%');
        });

        $query->when(request()->input('direccion'), function ($q) {
            return $q->where('direccion', 'like', '%' . request()->input('direccion') . '%');
        });

        $query->when(request()->input('telefono'), function ($q) {
            return $q->where('telefono', 'like', '%' . request()->input('telefono') . '%');
        });

        $query->when(request()->input('NIT'), function ($q) {
            return $q->where('NIT', 'like', '%' . request()->input('NIT') . '%');
        });

        $query->when(request()->input('org_id'), function ($q) {
            $q->whereHas('GrupoOrgnanismo', function ($q) {
                $q->whereHas('organismo', function ($q) {
                    return $q->where('org_id', request()->input('org_id'));
                });
            });
        });

        $query->when(request()->input('grupo_id'), function ($q) {
            $q->whereHas('GrupoOrgnanismo', function ($q) {
                $q->whereHas('grupo', function ($q) {
                    return $q->where('grupo_id', request()->input('grupo_id'));
                });
            });
        });

        $query->when(request()->input('activo'), function ($q) {
            return $q->where('activo', 1);
        });

        $query->when(request()->input('cliente'), function ($q) {
            $q->whereHas('ClienteProveedor', function ($q) {
                return $q->where('isClient', 1);
            });
        });

        $query->when(request()->input('proveedor'), function ($q) {
            $q->whereHas('ClienteProveedor', function ($q) {
                return $q->where('isProvider', 1);
            });
        });

        $entidad = $query->paginate(50);
        $organismos = Organismo::where('activo', 1)->get();
        $grupos = Grupo::where('activo', 1)->get();
        return view('entidad.index', compact('entidad', 'organismos', 'grupos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $entidad = Entidad::where("identidad", $id)->get()[0];
        $grupos = Grupo::all();
        $organismos = Organismo::all();
        return view('entidad.edit', compact('entidad', 'grupos', 'organismos'));
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
            'org_id' => 'required',
            'grupo_id' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);
        $orgGrupo = entidadGrupoOrganismo::where("entidad_id", $id)->get();
        if(count($orgGrupo) > 0) {
            $orgGrupo[0]->org_id = $request->input('org_id');
            $orgGrupo[0]->grupo_id = $request->input('grupo_id') === "Grupo no seleccionado" ? null :$request->input('grupo_id');
            $orgGrupo[0]->update();
        } else {
            $newOrgGrupo = new entidadGrupoOrganismo();
            $newOrgGrupo->entidad_id = $id;
            $newOrgGrupo->org_id = $request->input('org_id');
            $newOrgGrupo->grupo_id = $request->input('grupo_id') === "Grupo no seleccionado" ? null :$request->input('grupo_id');
            $newOrgGrupo->save();
        }

        $clientProveedor = entidadClientProvider::where("entidad_id", $id)->get();
        if(count($clientProveedor) > 0) {
            $clientProveedor[0]->isClient = $request->input('cliente') ? 1 : 0;
            $clientProveedor[0]->isProvider = $request->input('proveedor') ? 1 : 0;
            $clientProveedor[0]->update();
        } else {
            $newClientProveedor = new entidadClientProvider();
            $newClientProveedor->entidad_id = $id;
            $newClientProveedor->isClient = $request->input('cliente') ? 1 : 0;
            $newClientProveedor->isProvider = $request->input('proveedor') ? 1 : 0;
            $newClientProveedor->save();
        }
        return redirect('/entidad')->with('status', 'Entidad Editada satisfactoriamente');
    }

    public function delete($id)
    {
        $entidad = entidad::find($id);
        return view('entidad.delete', compact('entidad'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entidad = entidad::find($id);
        $entidad->delete();
        return redirect()->back()->with('status', 'Entidad eliminada Satisfactoriamente');
    }

    public function fileImportExport()
    {
        return view('entidad.file-import');
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function fileImport(Request $request)
    {
        Excel::import(new EntidadImport, request()->file('file'));

        return back()->with('success', 'User Imported Successfully.');
    }

    public function export()
    {
        return Excel::download(new EntidadExport, 'entidades.xlsx');
    }
}
