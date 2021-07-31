<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\ClienteProveedor;
use App\Models\ContratoMarco;
use App\Models\EntidadAreaServico;
use App\Models\EntidadCP;
use App\Models\EntidadGO;
use App\Models\Grupo;
use App\Models\ObjetoCM;
use App\Models\Organismo;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function entidadSearch(Request $request){
        $codInt = $request->input('codInterno');
        $codReu = $request->input('codReu');
        $nombre = $request->input('nombre');
        $siglas = $request->input('siglas');
        $cliente = $request->input('cliente');
        $proveedor = $request->input('proveedor');
        $organismo_id = $request->input('organismo_id');
        $grupo = $request->input('grupo');

        if($organismo_id == "1"){
            $organismo_id = null;
        }

        if($grupo == "1" || $grupo == "Grupo no seleccionado"){
            $grupo = null;
        }
        //$cliente_proveedor = ClienteProveedor::paginate(50);
        $CP = EntidadCP::all();
        $GO = EntidadGO::all();
        $grupos = Grupo::all();
        $organismos = Organismo::all();
        //dd($organismo_id);
        $BaseQuery = ClienteProveedor::query()
        ->join("entidad_c_p_s",'entidad_c_p_s.idClientCP', '=', 'identidad')
        ->join("entidad_g_o_s",'entidad_g_o_s.idClientGO', '=', 'identidad')
        ->join("grupos",'grupos.id', '=', 'idGrupo')
        ->join("organismos", 'organismos.id', '=', 'idOrganismo')
        ->get();

        $cliente_proveedor = collect([]);
        for ($i=0; $i < count($BaseQuery); $i++) {
            $cliente_proveedor->push($BaseQuery[$i]);
        }

        if ($cliente != null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->cliente, '1' )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }
       //dd($request);
        if ($proveedor!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->proveedor, '1' )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }

        if ($codInt!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->codigo, $codInt )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }

        if ($codReu!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->codigoreu, $codReu )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }

        if ($nombre!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->nombre, $nombre )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }

        if ($siglas!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->abreviatura, $siglas )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }
        //dd($organismo_id);
        if ($organismo_id!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->idOrganismo, $organismo_id )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }

        if ($grupo!= null || $grupo != "1") {
            $aux = collect([]);
            for ($i=0; $i < count($cliente_proveedor); $i++) {
                if(strstr( $cliente_proveedor[$i]->idGrupo, $grupo )){
                    $aux->push($cliente_proveedor[$i]);
                }
            }
            $cliente_proveedor = $aux;
        }
        //dd($cliente_proveedor);
        $links = false;
        return view('cliente_proveedor.index', compact('cliente_proveedor', 'CP','GO','organismos','grupos','links'));
    }

    public function organismoSearch(Request $request){
        $cod = $request->input('codigo');
        $nombre = $request->input('nombre');
        $siglas = $request->input('siglas');
        $activo = $request->input('activo');


        $BaseQuery = Organismo::query()
        ->get();

        $organismo = collect([]);
        for ($i=0; $i < count($BaseQuery); $i++) {
            $organismo->push($BaseQuery[$i]);
        }

        if ($cod != null) {
            $aux = collect([]);
            for ($i=0; $i < count($organismo); $i++) {
                if(strstr( $organismo[$i]->codigoO, $cod )){
                    $aux->push($organismo[$i]);
                }
            }
            $organismo = $aux;
        }

        if ($siglas != null) {
            $aux = collect([]);
            for ($i=0; $i < count($organismo); $i++) {
                if(strstr( $organismo[$i]->siglasO, $siglas )){
                    $aux->push($organismo[$i]);
                }
            }
            $organismo = $aux;
        }

        if ($nombre != null) {
            $aux = collect([]);
            for ($i=0; $i < count($organismo); $i++) {
                if(strstr( $organismo[$i]->nombreO, $nombre )){
                    $aux->push($organismo[$i]);
                }
            }
            $organismo = $aux;
        }

        if ($activo != null) {
            $aux = collect([]);
            for ($i=0; $i < count($organismo); $i++) {
                if($organismo[$i]->activoO == $activo){
                    $aux->push($organismo[$i]);
                }
            }
            $organismo = $aux;
        }
        //dd($activo);
        //$organismo = Organismo::all();
        $links = false;
        return view('organismo.index',compact('organismo','links'));
    }

    public function grupoSearch(Request $request){
        $cod = $request->input('codigo');
        $nombre = $request->input('nombre');
        $siglas = $request->input('siglas');
        $organismo_id = $request->input('organismo');
        if($organismo_id == "1"){
            $organismo_id = null;
        }
        $organismo = Organismo::all();

        $BaseQuery = Grupo::query()
        ->get();

        $grupo = collect([]);
        for ($i=0; $i < count($BaseQuery); $i++) {
            $grupo->push($BaseQuery[$i]);
        }

        if ($cod != null) {
            $aux = collect([]);
            for ($i=0; $i < count($grupo); $i++) {
                if(strstr( $grupo[$i]->codigoG, $cod )){
                    $aux->push($grupo[$i]);
                }
            }
            $grupo = $aux;
        }

        if ($siglas != null) {
            $aux = collect([]);
            for ($i=0; $i < count($grupo); $i++) {
                if(strstr( $grupo[$i]->siglasG, $siglas )){
                    $aux->push($grupo[$i]);
                }
            }
            $grupo = $aux;
        }

        if ($nombre != null) {
            $aux = collect([]);
            for ($i=0; $i < count($grupo); $i++) {
                if(strstr( $grupo[$i]->nombreG, $nombre )){
                    $aux->push($grupo[$i]);
                }
            }
            $grupo = $aux;
        }

        if ($organismo != null) {
            $aux = collect([]);
            for ($i=0; $i < count($grupo); $i++) {
                if(strstr( $grupo[$i]->id_Organismo, $organismo_id )){
                    $aux->push($grupo[$i]);
                }
            }
            $grupo = $aux;
        }
        //dd($activo);
        //$organismo = Organismo::all();
        //$grupo = Grupo::all();
        $links = false;
        return view('grupo.index',compact('grupo','organismo','links'));
    }

    public function servicioSearch(Request $request){
        $cod = $request->cod;
        $serv = $request->serv;
        $area = $request->area;
        $none = "";
        if($area == "@"){
            $area = null;
        }

        $BaseQuery = Servicio::query()
            ->join("entidad_area_servicios",'entidad_area_servicios.idServicioS', '=', 'idservicio')
            ->get();

        $BaseQuery2 = Area::all();

        for ($i=0; $i < count($BaseQuery); $i++) { 
            for ($j=0; $j < count($BaseQuery2); $j++) { 
            if($BaseQuery[$i]->idAreaA == $BaseQuery2[$j]->idarea){
                $BaseQuery[$i]->Expr4 = $BaseQuery2[$j]->Expr4;
            }
            }
        }

        for ($i=0; $i < count($BaseQuery); $i++) { 
            if($BaseQuery[$i]->Expr4 < 10){
                $BaseQuery[$i]->Expr4 = $none;
            }
        }

            $service = collect([]);
            for ($i=0; $i < count($BaseQuery); $i++) {
                $service->push($BaseQuery[$i]);
            }

        if ($cod != null) {
            $aux = collect([]);
            for ($i=0; $i < count($service); $i++) {
                if(strstr( $service[$i]->codigo, $cod )){
                    $aux->push($service[$i]);
                }
            }
            $service = $aux;
        }

        if ($serv != null) {
            $aux = collect([]);
            for ($i=0; $i < count($service); $i++) {
                if(strstr( $service[$i]->Descripcion, $serv )){
                    $aux->push($service[$i]);
                }
            }
            $service = $aux;
        }

        if ($area != null) {
            $aux = collect([]);
            for ($i=0; $i < count($service); $i++) {
                if(strstr( $service[$i]->idAreaA, $area )){
                    $aux->push($service[$i]);
                }
            }
            $service = $aux;
        }

        $servicios = $service;
        //dd($servicios);
        $entidadAS = EntidadAreaServico::all();
        $area = Area::all();
        $links = false;
        //dd($service);
        //$organismo = Organismo::all();
        return view('servicio_area.index',compact('servicios','entidadAS','area','links'));
    }

    public function objetoCMSearch(Request $request){
        $obj = $request->input('obj');
        $BaseQuery = ObjetoCM::all();

        $objeto = collect([]);

        for ($i=0; $i < count($BaseQuery); $i++) {
            $objeto->push($BaseQuery[$i]);
        }

        if ($obj != null) {
            $aux = collect([]);
            for ($i=0; $i < count($objeto); $i++) {
                if(strstr( $objeto[$i]->nombre, $obj )){
                    $aux->push($objeto[$i]);
                }
            }
            $objeto = $aux;
        }
        $links = false;
        return view('objeto_CM.index',compact('objeto','links'));
    }

    public function CMSearch(Request $request){
        $objeto = $request->input('objeto');
        if($objeto == "@"){
            $objeto = null;
        }
        $organismo = $request->input('organismo');
        if($organismo == "1"){
            $organismo = null;
        }
        $grupo = $request->input('grupo');
        if($grupo == "1"){
            $grupo = null;
        }
        $estado = $request->input('estado');
        if($estado == "@"){
            $estado = null;
        }
        $noCM = $request->input('noCM');
        $cliente = $request->input('cliente');
        $codInt = $request->input('codInt');
        $codReu = $request->input('codReu');
        $FfechaIni = $request->input('FfechaIni');
        $FfechaEnd = $request->input('FfechaEnd');
        $VfechaIni = $request->input('VfechaIni');
        $VfechaEnd = $request->input('VfechaEnd');

        if($FfechaIni == null){
            $FfechaEnd = null;
        }

        if($VfechaIni == null){
            $VfechaEnd = null;
        }

        //dd($request);
        $BaseQuery = ContratoMarco::query()
        ->join("grupos",'grupos.id', '=', 'grupo')
        ->join("organismos", 'organismos.id', '=', 'organismo')
        ->join("ClientsView", 'ClientsView.identidad', "=", 'idClient')
        ->get();

        $CM = collect([]);
        for ($i=0; $i < count($BaseQuery); $i++) {
            $CM->push($BaseQuery[$i]);
        }
        //dd($CM);
        if ($objeto!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($CM); $i++) {
                if(strstr( $CM[$i]->objeto, $objeto )){
                    $aux->push($CM[$i]);
                }
            }
            $CM = $aux;
        }

        if ($organismo!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($CM); $i++) {
                if(strstr( $CM[$i]->organismo, $organismo )){
                    $aux->push($CM[$i]);
                }
            }
            $CM = $aux;
        }

        if ($grupo!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($CM); $i++) {
                if(strstr( $CM[$i]->grupo, $grupo )){
                    $aux->push($CM[$i]);
                }
            }
            $CM = $aux;
        }

        if ($estado!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($CM); $i++) {
                if(strstr( $CM[$i]->estado, $estado )){
                    $aux->push($CM[$i]);
                }
            }
            $CM = $aux;
        }

        if ($noCM!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($CM); $i++) {
                if(strstr( $CM[$i]->noContrato, $noCM )){
                    $aux->push($CM[$i]);
                }
            }
            $CM = $aux;
        }

        if ($cliente!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($CM); $i++) {
                if(strstr( $CM[$i]->idClient, $cliente )){
                    $aux->push($CM[$i]);
                }
            }
            $CM = $aux;
        }

        if ($codInt!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($CM); $i++) {
                if(strstr( $CM[$i]->codigo, $codInt )){
                    $aux->push($CM[$i]);
                }
            }
            $CM = $aux;
        }

        if ($codReu!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($CM); $i++) {
                if(strstr( $CM[$i]->codigoreu, $codReu )){
                    $aux->push($CM[$i]);
                }
            }
            $CM = $aux;
        }

        if ($codReu!= null) {
            $aux = collect([]);
            for ($i=0; $i < count($CM); $i++) {
                if(strstr( $CM[$i]->codigoreu, $codReu )){
                    $aux->push($CM[$i]);
                }
            }
            $CM = $aux;
        }
        if($FfechaIni != null && $FfechaEnd != null){
            $initialDate = Carbon::parse($FfechaIni)->format('d-m-y');
            $endDate = Carbon::parse($FfechaEnd)->format('d-m-y');
            $FfechaIni = Carbon::createFromFormat('d-m-y', $initialDate);
            $FfechaEnd = Carbon::createFromFormat('d-m-y', $endDate);
            $aux = collect([]);
            for ($i=0; $i < count($CM); $i++) {
                $ini = Carbon::parse($CM[$i]->fechaIni)->format('d-m-y');
                $fechaIni = Carbon::createFromFormat('d-m-y',$ini);
                if($fechaIni->gte($FfechaIni) && $fechaIni->lte($FfechaEnd)){
                    $aux->push($CM[$i]);
                }
            }
            $CM = $aux;
        }
        if($FfechaIni != null && $FfechaEnd == null){
           $initialDate = Carbon::parse($FfechaIni)->format('d-m-y');
           $FfechaIni = Carbon::createFromFormat('d-m-y', $initialDate);
            $aux = collect([]);
            for ($i=0; $i < count($CM); $i++) {
                $ini = Carbon::parse($CM[$i]->fechaIni)->format('d-m-y');
                $fechaIni = Carbon::createFromFormat('d-m-y',$ini);
                if($fechaIni->gte($FfechaIni)){
                    $aux->push($CM[$i]);
                }
            }
            $CM = $aux;
        }

        if($VfechaIni != null && $VfechaEnd != null){  
            $initialDate = Carbon::parse($VfechaIni)->format('d-m-y');
            $endDate = Carbon::parse($VfechaEnd)->format('d-m-y');
            $VfechaIni = Carbon::createFromFormat('d-m-y', $initialDate);
            $VfechaEnd = Carbon::createFromFormat('d-m-y', $endDate);
            $aux = collect([]);
            for ($i=0; $i < count($CM); $i++) {
                $ini = Carbon::parse($CM[$i]->fechaEnd)->format('d-m-y');
                $fechaEnd = Carbon::createFromFormat('d-m-y',$ini);
                if($fechaEnd->gte($VfechaIni) && $fechaEnd->lte($VfechaEnd)){
                    $aux->push($CM[$i]);
                }
            }
            $CM = $aux;
        }
        if($VfechaIni != null && $VfechaEnd == null){
           $initialDate = Carbon::parse($VfechaIni)->format('d-m-y');
           $VfechaIni = Carbon::createFromFormat('d-m-y', $initialDate);
            $aux = collect([]);
            for ($i=0; $i < count($CM); $i++) {
                $ini = Carbon::parse($CM[$i]->fechaEnd)->format('d-m-y');
                $fechaEnd = Carbon::createFromFormat('d-m-y',$ini);
                if($fechaEnd->gte($VfechaIni)){
                    $aux->push($CM[$i]);
                }
            }
            $CM = $aux;
        }

        $now = Carbon::now()->format('d-m-y');
        $ThreeDaysearly = Carbon::now()->addDays(3)->format('d-m-y');
        $organismos = Organismo::all();
        $objeto = ObjetoCM::all();
        $links = false;
        return view('contratos_marco.index',compact('CM','now','ThreeDaysearly','organismos','objeto','links','now','ThreeDaysearly'));
    }
}
