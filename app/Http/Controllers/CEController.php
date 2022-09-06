<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\CE;
use App\Models\CM;
use App\Models\Entidad;
use App\Models\entidadServCE;
use App\Models\estadoCE;
use App\Models\Grupo;
use App\Models\Organismo;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = CE::query();

        $query->when(request()->input('noContratoEsp'), function ($q) {
            return $q->where('noCE', request()->input('noContratoEsp'));
        });

        $query->when(request()->input('noContrato'), function ($q) {
            $q->whereHas('cm', function ($q) {
                return $q->where('noContrato', 'like', '%' . request()->input('noContrato') . '%');
            });
        });

        $query->when(request()->input('codigo'), function ($q) {
            $q->whereHas('cm', function ($q) {
                $q->whereHas('cliente', function ($q) {
                    $q->whereHas('entidad', function ($q) {
                        return $q->where('codigo', 'like', '%' . request()->input('codigo') . '%');
                    });
                });
            });
        });

        $query->when(request()->input('codigoreu'), function ($q) {
            $q->whereHas('cm', function ($q) {
                $q->whereHas('cliente', function ($q) {
                    $q->whereHas('entidad', function ($q) {
                        return $q->where('codigoreu', 'like', '%' . request()->input('codigoreu') . '%');
                    });
                });
            });
        });

        $query->when(request()->input('codigoserv'), function ($q) {
            $q->whereHas('servicios', function ($q) {
                $q->whereHas('servicio', function ($q) {
                    return $q->where('codigo', 'like', '%' . request()->input('codigoserv') . '%');
                });
            });
        });

        if (request()->input('area_id') && request()->input('area_id') !== '@') {
            $query->when(request()->input('area_id'), function ($q) {
                return $q->where('area_id', request()->input('area_id'));
            });
        }

        if (request()->input('servicio_id') && request()->input('servicio_id') !== '@') {
            $query->when(request()->input('servicio_id'), function ($q) {
                $q->whereHas('servicios', function ($q) {
                    $q->whereHas('servicio', function ($q) {
                        return $q->where('idservicio', request()->input('servicio_id'));
                    });
                });
            });
        }

        $query->when(request()->input('estado_id'), function ($q) {
            $q->whereHas('estado', function ($q) {
                return $q->where('id', request()->input('estado_id'));
            });
        });

        if (request()->input('org_id') && request()->input('org_id') !== '@') {
            $query->when(request()->input('org_id'), function ($q) {
                $q->whereHas('cm', function ($q) {
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
            });
        }

        if (request()->input('grupo_id') && request()->input('grupo_id') !== '@') {
            $query->when(request()->input('grupo_id'), function ($q) {
                $q->whereHas('cm', function ($q) {
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
            });
        }

        if (request()->input('cliente_id') && request()->input('cliente_id') !== '@') {
            $query->when(request()->input('cliente_id'), function ($q) {
                $q->whereHas('cm', function ($q) {
                    $q->whereHas('cliente', function ($q) {
                        $q->whereHas('entidad', function ($q) {
                            return $q->where('identidad', request()->input('cliente_id'));
                        });
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

        $query->when(request()->input('montoFrom'), function ($q) {
            return $q->where('monto', '>=', request()->input('montoFrom'));
        });

        $query->when(request()->input('montoTo'), function ($q) {
            return $q->where('monto', '<=', request()->input('montoTo'));
        });

        $ces = $query->orderBy('id', 'desc')->paginate(30);
        $cm = null;
        $now = Carbon::now();
        $areas = Area::where('activa', 1)->get();
        $servicios = Servicio::all();
        $estados = estadoCE::where('activo', 1)->get();
        $organismos = Organismo::where('activo', 1)->get();
        $grupos = Grupo::where('activo', 1)->get();
        $clientes = Entidad::whereHas('ClienteProveedor', function ($q) {
            return $q->where('isClient', 1);
        })->get();
        return view('ce.index', compact('ces', 'cm', 'now', 'areas', 'servicios', 'estados', 'organismos', 'grupos', 'clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $ce = 'none';
        $areas = Area::where('activa', 1)->get();
        $servicios = Servicio::all();
        $estados = estadoCE::all();
        $cm = CM::find($id);
        return view('ce.edit', compact('ce', 'cm', 'areas', 'servicios', 'estados', 'id'));
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
            'fechaIni' => 'required',
            'area_id' => 'required',
            'serv_id' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $ces = CE::where('c_m_id', $id)->get();

        $noCe = 1;

        if (count($ces) > 0) {
            $noCe = count($ces) + 1;
        }

        $ce = new CE();
        $ce->c_m_id = $id;
        $ce->ejecutor = $request->input('ejecutor');
        $ce->cliente = $request->input('cliente');
        $ce->observ = $request->input('observ');
        $ce->fechaFirma = $request->input('fechaIni') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaIni'))->toDateString() : null;
        $ce->fechaVenc = $request->input('fechaEnd') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaEnd'))->toDateString() : null;
        $ce->noCE = $noCe;
        $ce->estado_c_e_id = $request->input('estado_id');
        $ce->area_id = $request->input('area_id');
        $ce->monto =  $request->input('monto');
        $ce->save($validatedData);

        if ($request->input('serv_id') !== null) {
            foreach ($request->input('serv_id') as $servicio) {
                $servCe = new entidadServCE();
                $servCe->serv_id = $servicio;
                $servCe->ce_id = $ce->id;
                $servCe->save();
            }
        }
        return redirect('/ce/' . $id)->with('status', 'Contrato Específico Creado satisfactoriamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $query = CE::query();

        $query->when(request()->input('noContratoEsp'), function ($q) {
            return $q->where('noCE', request()->input('noContratoEsp'));
        });

        $query->when(request()->input('noContrato'), function ($q) {
            $q->whereHas('cm', function ($q) {
                return $q->where('noContrato', 'like', '%' . request()->input('noContrato') . '%');
            });
        });

        $query->when(request()->input('codigo'), function ($q) {
            $q->whereHas('cm', function ($q) {
                $q->whereHas('cliente', function ($q) {
                    $q->whereHas('entidad', function ($q) {
                        return $q->where('codigo', 'like', '%' . request()->input('codigo') . '%');
                    });
                });
            });
        });

        $query->when(request()->input('codigoreu'), function ($q) {
            $q->whereHas('cm', function ($q) {
                $q->whereHas('cliente', function ($q) {
                    $q->whereHas('entidad', function ($q) {
                        return $q->where('codigoreu', 'like', '%' . request()->input('codigoreu') . '%');
                    });
                });
            });
        });

        $query->when(request()->input('codigoserv'), function ($q) {
            $q->whereHas('servicios', function ($q) {
                $q->whereHas('servicio', function ($q) {
                    return $q->where('codigo', 'like', '%' . request()->input('codigoserv') . '%');
                });
            });
        });

        if (request()->input('area_id') && request()->input('area_id') !== '@') {
            $query->when(request()->input('area_id'), function ($q) {
                return $q->where('area_id', request()->input('area_id'));
            });
        }

        if (request()->input('servicio_id') && request()->input('servicio_id') !== '@') {
            $query->when(request()->input('servicio_id'), function ($q) {
                $q->whereHas('servicios', function ($q) {
                    $q->whereHas('servicio', function ($q) {
                        return $q->where('idservicio', request()->input('servicio_id'));
                    });
                });
            });
        }

        $query->when(request()->input('estado_id'), function ($q) {
            $q->whereHas('estado', function ($q) {
                return $q->where('id', request()->input('estado_id'));
            });
        });

        if (request()->input('org_id') && request()->input('org_id') !== '@') {
            $query->when(request()->input('org_id'), function ($q) {
                $q->whereHas('cm', function ($q) {
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
            });
        }

        if (request()->input('grupo_id') && request()->input('grupo_id') !== '@') {
            $query->when(request()->input('grupo_id'), function ($q) {
                $q->whereHas('cm', function ($q) {
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
            });
        }

        if (request()->input('cliente_id') && request()->input('cliente_id') !== '@') {
            $query->when(request()->input('cliente_id'), function ($q) {
                $q->whereHas('cm', function ($q) {
                    $q->whereHas('cliente', function ($q) {
                        $q->whereHas('entidad', function ($q) {
                            return $q->where('identidad', request()->input('cliente_id'));
                        });
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

        $query->when(request()->input('montoFrom'), function ($q) {
            return $q->where('monto', '>=', request()->input('montoFrom'));
        });

        $query->when(request()->input('montoTo'), function ($q) {
            return $q->where('monto', '<=', request()->input('montoTo'));
        });

        $ces = $query->where('c_m_id', $id)->paginate(10);
        $cm = CM::find($id);
        $now = Carbon::now();
        $areas = Area::where('activa', 1)->get();
        $servicios = Servicio::all();
        $estados = estadoCE::where('activo', 1)->get();
        $organismos = Organismo::where('activo', 1)->get();
        $grupos = Grupo::where('activo', 1)->get();
        $clientes = Entidad::whereHas('ClienteProveedor', function ($q) {
            return $q->where('isClient', 1);
        })->get();
        return view('ce.index', compact('ces', 'cm', 'now', 'areas', 'servicios', 'estados', 'organismos', 'grupos', 'clientes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ce = CE::find($id);
        $cm = CM::find($ce->c_m_id);
        $areas = Area::where('activa', 1)->get();
        $servicios = Servicio::all();
        $estados = estadoCE::all();

        return view('ce.edit', compact('ce', 'cm', 'areas', 'servicios', 'estados', 'id'));
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
            'fechaIni' => 'required',
            'area_id' => 'required',
            'serv_id' => 'required'
        ], [
            'required' => 'Este campo es requerido'
        ]);

        $ce = CE::find($id);
        $ce->ejecutor = $request->input('ejecutor');
        $ce->cliente = $request->input('cliente');
        $ce->observ = $request->input('observ');
        $ce->fechaFirma = $request->input('fechaIni') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaIni'))->toDateString() : null;
        $ce->fechaVenc = $request->input('fechaEnd') ? Carbon::createFromFormat('Y-m-d', $request->input('fechaEnd'))->toDateString() : null;
        $ce->estado_c_e_id = $request->input('estado_id');
        $ce->area_id = $request->input('area_id');
        $ce->monto =  $request->input('monto');
        $ce->update($validatedData);

        if ($request->input('serv_id') !== null) {

            $servCe = entidadServCE::where('ce_id', $id)->delete();

            foreach ($request->input('serv_id') as $servicio) {
                $servCe = new entidadServCE();
                $servCe->serv_id = $servicio;
                $servCe->ce_id = $ce->id;
                $servCe->save();
            }
        }

        return redirect('/ce/' . $ce->c_m_id)->with('status', 'Contrato Específico Editado satisfactoriamente');
    }

    public function delete($id)
    {
        $ce = CE::find($id);
        return view('ce.delete', compact('ce'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ce = CE::find($id);
        $ce->delete();
        return redirect()->back()->with('status', 'Contrato Específico eliminado Satisfactoriamente');
    }
}
