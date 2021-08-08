<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\EntidadGO;
use App\Models\ObjetoSuplementoCE;
use App\Models\ObjetoSuplementoCM;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DropdownController extends Controller
{
 public function index()
 {
 $countries = DB::table("organismos")->pluck("nombre","id");
 return view('welcome',compact('countries'));
 }

 public function getGrupo(Request $request)
 {
 $grupos = DB::table("grupos")
 ->where("id_Organismo",$request->organismo_id)
 ->pluck("nombreG","id");
 return response()->json($grupos);
 }

 public function getGrupoEntidad(Request $request)
 {
 $grupos = EntidadGO::where("idOrganismo",$request->organismo_id)
 ->join("dbo.grupos", 'dbo.grupos.id', '=', 'idGrupo')
 ->pluck("nombreG","idGrupo");
 return response()->json($grupos);
 }

 public function getClient(Request $request)
 {
    $clients = EntidadGO::where("idGrupo",$request->grupo_id)
    ->join("dbo.ClientsView", 'dbo.ClientsView.identidad', '=', 'idClientGO')
    ->pluck("dbo.ClientsView.nombre","idClientGO");
    return response()->json($clients);
 }

 public function getClientEntidad(Request $request)
 {
    $clients = EntidadGO::where("idGrupo",$request->grupoID)
    ->where("idOrganismo", $request->organismoID)
    ->join("dbo.ClientsView", 'dbo.ClientsView.identidad', '=', 'idClientGO')
    ->pluck("dbo.ClientsView.nombre","idClientGO");
    return response()->json($clients);
 }

 public function getServices(Request $request){
    $cod = $request->cod;
    $serv = $request->serv;
    $area = $request->area;
    $none = "";

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

      if ($cod != '@') {
         $aux = collect([]);
         for ($i=0; $i < count($service); $i++) {
             if(strstr( $service[$i]->codigo, $cod )){
                 $aux->push($service[$i]);
             }
         }
         $service = $aux;
      }

      if ($serv != '@') {
         $aux = collect([]);
         for ($i=0; $i < count($service); $i++) {
             if(strstr( $service[$i]->Descripcion, $serv )){
                 $aux->push($service[$i]);
             }
         }
         $service = $aux;
      }

      if ($area != '@') {
         $aux = collect([]);
         for ($i=0; $i < count($service); $i++) {
             if(strstr( $service[$i]->idAreaA, $area )){
                 $aux->push($service[$i]);
             }
         }
         $service = $aux;
      }

    return response()->json($service);
 }

 public function getObjetos(Request $request){
   $obj = $request->obj;

   $BaseQuery = ObjetoSuplementoCM::query()
       ->get();

       $objeto = collect([]);
       for ($i=0; $i < count($BaseQuery); $i++) {
         $objeto->push($BaseQuery[$i]);
       }

     if ($obj != '@') {
        $aux = collect([]);
        for ($i=0; $i < count($objeto); $i++) {
            if(strstr( $objeto[$i]->ObjetoSuplementoCM, $obj )){
                $aux->push($objeto[$i]);
            }
        }
        $objeto = $aux;
     }

   return response()->json($objeto);
   }

   public function getObjetos2(Request $request){
      $obj = $request->obj;
   
      $BaseQuery = ObjetoSuplementoCE::query()
          ->get();
   
          $objeto = collect([]);
          for ($i=0; $i < count($BaseQuery); $i++) {
            $objeto->push($BaseQuery[$i]);
          }
   
        if ($obj != '@') {
           $aux = collect([]);
           for ($i=0; $i < count($objeto); $i++) {
               if(strstr( $objeto[$i]->ObjetoSuplementoCE, $obj )){
                   $aux->push($objeto[$i]);
               }
           }
           $objeto = $aux;
        }
   
      return response()->json($objeto);
      }
}
