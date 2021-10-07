@extends('layouts.frontend')

@section('content')

<div class="mt-3" style="margin-left: 2%; margin-right: 2%">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if (session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
        @endif
            <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                Contratos Marco
                                <a href="{{url('contratos_marco/create')}}" class="btn btn-primary float-end">Añadir Contrato Marco</a>
                            </div>
                        </div>
                    
                        <br/>
                        <form action="{{ url('CMSearch') }}"  method="GET">
                            <div class="row">
                                <div class="col-5">
                                    <div class="row mb-2">
                                        <div class="col-3">
                                            No. Contrato:
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control form-control-sm" name="noCM"/>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4">
                                            Objeto del Contrato:
                                        </div>
                                        <div class="col-8">
                                            <select name="objeto" class="col-8 form-control form-control-sm">
                                                <option value="@">Ningún objeto seleccionado</option>
                                                @foreach ( $objeto as $item )
                                                <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                     <div class="row mb-2">
                                        <div class="col-3">
                                            Organismo:
                                        </div>
                                        <div class="col-9">
                                            <select id="organismo" name="organismo" class="col-8 form-control form-control-sm">
                                                @foreach ( $organismos as $item )
                                                <option value="{{$item->id}}">{{$item->nombreO}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div> 
                                    <div class="row mb-2">
                                        <div class="col-3">
                                            Grupo:
                                        </div>
                                        <div class="col-9">
                                            <select name="grupo" id="grupo" class="col-8 form-control form-control-sm">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-3">
                                            Cliente-Proveedor:
                                        </div>
                                        <div class="col-9">
                                            <select name="cliente" id="client" class="col-8 form-control form-control-sm">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            Fecha de firma Desde:
                                        </div>
                                        <div class="col-7">
                                            <input type='text' class="form-control form-control-sm" id="datepicker"  name="FfechaIni" />
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            Hasta:
                                        </div>
                                        <div class="col-7">
                                            <input type='text' class="form-control form-control-sm" id="datepicker2"  name="FfechaEnd" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="row mb-2">
                                        <div class="col-3">
                                            Cod. Interno:
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control form-control-sm" name="codInt"/>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-3">
                                            Cod. REEUP:
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control form-control-sm" name="codReu"/>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            Estado:
                                        </div>
                                        <div class="col-7">
                                            <select name="estado" class="col-8 form-control form-control-sm">
                                                <option value="@">Ningún estado seleccionado</option>
                                                <option value="Vigente">Vigente</option>
                                                <option value="Vencido">Vencido</option>
                                                <option value="Cancelado">Cancelado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            Fecha de venc. Desde:
                                        </div>
                                        <div class="col-7">
                                            <input type='text' class="form-control form-control-sm" id="datepicker3"  name="VfechaIni" />
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-5">
                                            Hasta:
                                        </div>
                                        <div class="col-7">
                                            <input type='text' class="form-control form-control-sm" id="datepicker4"  name="VfechaEnd" />
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-2">
                                            Cliente:
                                        </div>
                                        <div class="col-3">
                                            <input  type="checkbox" name="client"></p>
                                        </div>
                                        <div class="col-3">
                                            Proveedor:
                                        </div>
                                        <div class="col-3">
                                            <input  type="checkbox" name="proveedor"></p>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <button class="btn btn-primary" type="submit">Buscar</button>
                                        <a class="btn btn-primary" id="button-a">Excel</a>
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-sm table-striped" id="mytable">
                        <thead>
                            <tr style="font-size: 70%;">
                                <th style="width: 20px;">No.Contrato</th>
                                <th style="width: 20px;">Código Interno</th>
                                <th style="width: 40px;">Código REEUP</th>
                                <th style="width: 120px;">Cliente</th>
                                <th style="width: 80px;">Siglas</th>
                                <th style="width: 80px;">OACES</th>
                                <th style="width: 120px;">Objeto del Contrato</th>
                                <th style="width: 20px;">Estado</th>
                                <th style="width: 80px;">Fecha de Firma</th>
                                <th style="width: 80px;">Fecha de Vencimiento</th>
                                <th style="width: 120px;">Observaciones</th>
                                <th style="width: 10px;">Contrato</th>
                                <th style="width: 10px;">Contratos Específicos</th>
                                <th style="width: 10px;">Suplementos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($CM as $item)
                                <tr  class = "{{ \Carbon\Carbon::createFromFormat('d-m-y', \Carbon\Carbon::parse($item->fechaEnd)->format('d-m-y'))->gte($now) 
                                                    &&
                                                 \Carbon\Carbon::createFromFormat('d-m-y', \Carbon\Carbon::parse($item->fechaEnd)->format('d-m-y'))->lte($ThreeDaysearly) 
                                                    ? 'bg-warning' : ''}}"
                                style="font-size: 70%; {{$item->estado == 'Vencido' ? 'background-color: red' : ''}}"
                                >
                                    <td><a href="{{url('contratos_marco/'.$item->id.'/edit')}}">{{$item->noContrato}}</a></td>
                                    <td><a href="{{url('clientes_proveedores/'.$item->idClient.'/edit')}}">{{$item->cliente->codigo}}</a></td>
                                    <td>{{$item->cliente->codigoreu}}</td>
                                    <td>{{$item->cliente->nombre}}</td>
                                    <td>{{$item->cliente->abreviatura}}</td>
                                    <td>{{$item->organismos->siglasO}}/{{$item->grupos->siglasG}}</td>
                                    <td>{{$item->objeto}}</td>
                                    <td>{{$item->estado}}</td>
                                    <td>{{$item->fechaIni}}</td>
                                    <td>{{$item->fechaEnd}}</td>
                                    <td>{{$item->observaciones}}</td>
                                    <td><a href="http://192.168.168.18//SistemaDeContratosv1.1/storage/app/public/{{$item->idFile}}"><svg xmlns="http://www.w3.org/2000/svg" style="width: 15%;" viewBox="0 0 384 512"><!-- Font Awesome Free 5.15.3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48z"/></svg></a></td>
                                    <td><a href="{{url('contratos_especificos/'.$item->id)}}">CE</a></td>
                                    <td><a href="{{url('suplementocm/'.$item->id)}}">Sup</a></td>
                                </tr>
                         @endforeach
                        </tbody>
                    </table>
                    @if ($links)
                    {{$CM->links()}}   
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/moment.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
   
    <script src="{{ asset('frontend/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script type="text/javascript">
        $('#datepicker').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    </script>
        <script type="text/javascript">
        $('#datepicker2').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    </script>
    <script type="text/javascript">
        $('#datepicker3').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    </script>
        <script type="text/javascript">
        $('#datepicker4').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    </script>
    <script type=text/javascript>
        organismo = 1;
        $('#organismo').change(function(){
        var organismoID = $(this).val();
        organismo = organismoID;
        if(organismoID){
            $.ajax({
                type:"GET",
                url:"{{url('getGrupoEntidad')}}?organismo_id="+organismoID,
                success:function(res){
                    if(res){
                        $("#grupo").empty();
                        $("#client").empty();
                        $("#grupo").append('<option>Seleccione un grupo</option>');
                        $.each(res,function(key,value){
                            $("#grupo").append('<option value="'+key+'">'+value+'</option>');
                        });

                    }else{
                        $("#grupo").empty();
                    }
                }
            });
        }else{
            $("#grupo").empty();
            $("#client").empty();
        }
        });
        $('#grupo').on('change',function(){
        var grupoID = $(this).val();
        if(grupoID){
            $.ajax({
                type:"GET",
                url:"{{url('getClientEntidad')}}/"+grupoID+'/org/'+ organismo,
                 success:function(res){
                    if(res){
                        $("#client").empty();
                        $("#client").append('<option>Seleccione un Cliente</option>');
                        $.each(res,function(key,value){
                        $("#client").append('<option value="'+key+'">'+value+'</option>');
                        });

                    }else{
                        $("#client").empty();
                    }
                }
            });
        }else{
            $("#client").empty();
        }

        });
    </script>
@endsection
