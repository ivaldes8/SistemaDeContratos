<?php

namespace App\Http\Controllers;

use App\Models\CP;
use App\Models\objSupCP;
use App\Models\supCP;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SupCPController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = supCP::query();

        $query->when(request()->input('noSuplemento'), function ($q) {
            return $q->where('nosupCP', 'like', '%' . request()->input('noSuplemento') . '%');
        });

        $query->when(request()->input('noContrato'), function ($q) {
            $q->whereHas('cp', function ($q) {
                return $q->where('noContrato', 'like', '%' . request()->input('noContrato') . '%');
            });
        });

        $query->when(request()->input('fechaIniFrom'), function ($q) {
            return $q->whereDate('fechaIni', '>=', Carbon::createFromFormat('d/m/Y', request()->input('fechaIniFrom'))->toDateString());
        });

        $query->when(request()->input('fechaIniTo'), function ($q) {
            return $q->whereDate('fechaIni', '<=', Carbon::createFromFormat('d/m/Y', request()->input('fechaIniTo'))->toDateString());
        });

        $query->when(request()->input('fechaEndFrom'), function ($q) {
            return $q->whereDate('fechaEnd', '<=', Carbon::createFromFormat('d/m/Y', request()->input('fechaEndFrom'))->toDateString());
        });

        $query->when(request()->input('fechaEndTo'), function ($q) {
            return $q->whereDate('fechaEnd', '>=', Carbon::createFromFormat('d/m/Y', request()->input('fechaEndTo'))->toDateString());
        });

        $supcps = $query->paginate(10);
        $cp = null;
        return view('supCP.index', compact('supcps', 'cp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $supcp = 'none';
        $objetos = objSupCP::where('activo', 1)->get();
        return view('supCP.edit', compact('supcp', 'objetos', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $validatedData = $request->validate([
            'objeto_id' => 'required',
            'ejecutor' => 'required',
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $sups = supCP::latest()->first();

        $noSup = 1;
        if ($sups) {
            $noSup = $sups->id + 1;
        }

        $supcp = new supCP();
        $supcp->cp_id = $id;
        $supcp->ejecutor = $request->input('ejecutor');
        $supcp->observ = $request->input('observ');
        $supcp->fechaIni = $request->input('fechaIni') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaIni'))->toDateString() : null;
        $supcp->fechaEnd = $request->input('fechaEnd') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaEnd'))->toDateString() : null;
        $supcp->noSupCP = $noSup;
        $supcp->save($validatedData);

        if ($request->input('objeto_id') !== null) {
            $supcp->objetos()->attach($request->input('objeto_id'));
        }
        return redirect('/supcp/' . $id)->with('status', 'Suplemento Creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = supCP::query();

        $query->when(request()->input('noSuplemento'), function ($q) {
            return $q->where('noSupCP', 'like', '%' . request()->input('noSuplemento') . '%');
        });

        $query->when(request()->input('noContrato'), function ($q) {
            $q->whereHas('cp', function ($q) {
                return $q->where('noContrato', request()->input('noContrato'));
            });
        });

        $query->when(request()->input('fechaIniFrom'), function ($q) {
            return $q->whereDate('fechaIni', '>=', Carbon::createFromFormat('d/m/Y', request()->input('fechaIniFrom'))->toDateString());
        });

        $query->when(request()->input('fechaIniTo'), function ($q) {
            return $q->whereDate('fechaIni', '<=', Carbon::createFromFormat('d/m/Y', request()->input('fechaIniTo'))->toDateString());
        });

        $query->when(request()->input('fechaEndFrom'), function ($q) {
            return $q->whereDate('fechaEnd', '<=', Carbon::createFromFormat('d/m/Y', request()->input('fechaEndFrom'))->toDateString());
        });

        $query->when(request()->input('fechaEndTo'), function ($q) {
            return $q->whereDate('fechaEnd', '>=', Carbon::createFromFormat('d/m/Y', request()->input('fechaEndTo'))->toDateString());
        });

        $supcps = $query->where('cp_id', $id)->paginate(10);
        $cp = CP::find($id);
        return view('supCP.index', compact('supcps', 'cp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supcp =  supCP::find($id);
        $objetos = objSupCP::where('activo', 1)->get();
        return view('supCP.edit', compact('supcp', 'objetos', 'id'));
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
            'objeto_id' => 'required',
            'ejecutor' => 'required',
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $supcp = supCP::find($id);
        $supcp->ejecutor = $request->input('ejecutor');
        $supcp->observ = $request->input('observ');
        $supcp->fechaIni = $request->input('fechaIni') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaIni'))->toDateString() : null;
        $supcp->fechaEnd = $request->input('fechaEnd') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaEnd'))->toDateString() : null;
        $supcp->update($validatedData);

        if ($request->input('objeto_id') !== null) {
            $supcp->objetos()->sync($request->input('objeto_id'));
        }
        return redirect('/supcp/' . $supcp->cp_id)->with('status', 'Suplemento Creado satisfactoriamente');
    }

    public function delete($id)
    {
        $supcp = supCP::find($id);
        return view('supCP.delete', compact('supcp'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supcp = supCP::find($id);
        $supcp->delete();
        return redirect()->back()->with('status', 'Suplemento eliminado Satisfactoriamente');
    }
}
