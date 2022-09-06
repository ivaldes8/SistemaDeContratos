<?php

namespace App\Http\Controllers;

use App\Models\CE;
use App\Models\Logs;
use App\Models\objSupCE;
use App\Models\supCE;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupCEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = supCE::query();

        $query->when(request()->input('noSuplemento'), function ($q) {
            return $q->where('noSupCM', 'like', '%' . request()->input('noSuplemento') . '%');
        });

        $query->when(request()->input('noContrato'), function ($q) {
            $q->whereHas('ce', function ($q) {
                return $q->where('noCE', 'like', '%' . request()->input('noContrato') . '%');
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

        $supces = $query->paginate(10);
        $ce = null;
        return view('supCE.index', compact('supces', 'ce'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $supce = 'none';
        $objetos = objSupCE::where('activo', 1)->get();
        return view('supCE.edit', compact('supce', 'objetos', 'id'));
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

        $sups = supCE::where('ce_id', $id)->get();

        $noSup = 1;

        if (count($sups) > 0) {
            $noSup = count($sups) + 1;
        }
        $supce = new supCE();
        $supce->ce_id = $id;
        $supce->ejecutor = $request->input('ejecutor');
        $supce->observ = $request->input('observ');
        $supce->fechaIni = $request->input('fechaIni') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaIni'))->toDateString() : null;
        $supce->fechaEnd = $request->input('fechaEnd') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaEnd'))->toDateString() : null;
        $supce->noSupCE = $noSup;
        $supce->save($validatedData);

        if ($request->input('objeto_id') !== null) {
            $supce->objetos()->attach($request->input('objeto_id'));
        }

        $logCE = new Logs();
        $logCE->user_id = Auth::user()->id;
        $logCE->action = 'create';
        $logCE->element = $supce->id;
        $logCE->type = 'supCE';
        $logCE->save();

        return redirect('/supce/' . $id)->with('status', 'Suplemento Creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = supCE::query();

        $query->when(request()->input('noSuplemento'), function ($q) {
            return $q->where('noSupCE', 'like', '%' . request()->input('noSuplemento') . '%');
        });

        $query->when(request()->input('noContrato'), function ($q) {
            $q->whereHas('ce', function ($q) {
                return $q->where('noContrato', request()->input('noCE'));
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

        $supces = $query->where('ce_id', $id)->paginate(10);
        $ce = CE::find($id);
        return view('supCE.index', compact('supces', 'ce'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supce =  supCE::find($id);
        $objetos = objSupCE::where('activo', 1)->get();
        return view('supCE.edit', compact('supce', 'objetos', 'id'));
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

        $supce = supCE::find($id);
        $supce->ejecutor = $request->input('ejecutor');
        $supce->observ = $request->input('observ');
        $supce->fechaIni = $request->input('fechaIni') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaIni'))->toDateString() : null;
        $supce->fechaEnd = $request->input('fechaEnd') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaEnd'))->toDateString() : null;
        $supce->update($validatedData);

        if ($request->input('objeto_id') !== null) {
            $supce->objetos()->sync($request->input('objeto_id'));
        }

        $logCE = new Logs();
        $logCE->user_id = Auth::user()->id;
        $logCE->action = 'edit';
        $logCE->element = $supce->id;
        $logCE->type = 'supCE';
        $logCE->save();

        return redirect('/supce/' . $supce->ce_id)->with('status', 'Suplemento Creado satisfactoriamente');
    }

    public function delete($id)
    {
        $supce = supCE::find($id);
        return view('supCE.delete', compact('supce'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supce = supCE::find($id);

        $logCE = new Logs();
        $logCE->user_id = Auth::user()->id;
        $logCE->action = 'delete';
        $logCE->element = $supce->id;
        $logCE->type = 'supCE';
        $logCE->save();

        $supce->delete();
        return redirect()->back()->with('status', 'Suplemento eliminado Satisfactoriamente');
    }
}
