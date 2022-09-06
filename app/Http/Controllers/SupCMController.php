<?php

namespace App\Http\Controllers;

use App\Models\CM;
use App\Models\objSupCM;
use App\Models\supCM;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SupCMController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = supCM::query();

        $query->when(request()->input('noSuplemento'), function ($q) {
            return $q->where('noSupCM', 'like', '%' . request()->input('noSuplemento') . '%');
        });

        $query->when(request()->input('noContrato'), function ($q) {
            $q->whereHas('cm', function ($q) {
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

        $supcms = $query->paginate(10);
        $cm = null;
        return view('supCM.index', compact('supcms', 'cm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $supcm = 'none';
        $objetos = objSupCM::where('activo', 1)->get();
        return view('supCM.edit', compact('supcm', 'objetos', 'id'));
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

        $sups = supCM::where('cm_id', $id)->get();

        $noSup = 1;

        if (count($sups) > 0) {
            $noSup = count($sups) + 1;
        }
        $supcm = new supCM();
        $supcm->cm_id = $id;
        $supcm->ejecutor = $request->input('ejecutor');
        $supcm->observ = $request->input('observ');
        $supcm->fechaIni = $request->input('fechaIni') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaIni'))->toDateString() : null;
        $supcm->fechaEnd = $request->input('fechaEnd') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaEnd'))->toDateString() : null;
        $supcm->noSupCM = $noSup;
        $supcm->save($validatedData);

        if ($request->input('objeto_id') !== null) {
            $supcm->objetos()->attach($request->input('objeto_id'));
        }
        return redirect('/supcm/' . $id)->with('status', 'Suplemento Creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = supCM::query();

        $query->when(request()->input('noSuplemento'), function ($q) {
            return $q->where('noSupCM', 'like', '%' . request()->input('noSuplemento') . '%');
        });

        $query->when(request()->input('noContrato'), function ($q) {
            $q->whereHas('cm', function ($q) {
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

        $supcms = $query->where('cm_id', $id)->paginate(10);
        $cm = CM::find($id);
        return view('supCM.index', compact('supcms', 'cm'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supcm =  supCM::find($id);
        $objetos = objSupCM::where('activo', 1)->get();
        return view('supCM.edit', compact('supcm', 'objetos', 'id'));
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

        $supcm = supCM::find($id);
        $supcm->ejecutor = $request->input('ejecutor');
        $supcm->observ = $request->input('observ');
        $supcm->fechaIni = $request->input('fechaIni') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaIni'))->toDateString() : null;
        $supcm->fechaEnd = $request->input('fechaEnd') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaEnd'))->toDateString() : null;
        $supcm->update($validatedData);

        if ($request->input('objeto_id') !== null) {
            $supcm->objetos()->sync($request->input('objeto_id'));
        }
        return redirect('/supcm/' . $supcm->cm_id)->with('status', 'Suplemento Creado satisfactoriamente');
    }

    public function delete($id)
    {
        $supcm = supCM::find($id);
        return view('supCM.delete', compact('supcm'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $supcm = supCM::find($id);
        $supcm->delete();
        return redirect()->back()->with('status', 'Suplemento eliminado Satisfactoriamente');
    }
}
