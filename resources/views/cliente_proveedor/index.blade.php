@extends('layouts.frontend')

@section('content')

<div class="mt-3">
    <div class="col-12 container">
    @if (session('status'))
        <div class="alert alert-success">{{session('status')}}</div>
    @endif
    <div class="card">
        <div class="card-header">
                <form action="{{ url('entidadSearch') }}" method="GET">
                    <div class="row">
                        <div class="col-2">
                            Código Interno:<input type="text" class="form-control" name="codInterno"/>
                        </div>
                        <div class="col-2">
                            Código REU:<input type="text" class="form-control" name="codReu"/>
                        </div>
                        <div class="col-3">
                            Nombre:<input type="text" class="form-control" name="nombre"/>
                        </div>
                        <div class="col-2">
                            Siglas:<input type="text" class="form-control" name="siglas"/>
                        </div>
                        <div class="col-3">
                            <p>Cliente-Proveeddor:</p>
                            <div style="margin-top: -10px;">
                                Cliente:<input type="checkbox" name="cliente"/>
                                Proveedor:<input type="checkbox" name="proveedor"/>
                            </div>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-4">
                            <label for="state">Organismo:</label>
                            <select id="organismo" name="organismo_id" class="col-8">
                                @foreach($organismos as $organismo)
                                <option value="{{$organismo->id}}" > {{$organismo->nombreO}}</>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="grupo">Seleccione un Grupo:</label>
                            <select name="grupo" id="grupo" class="col-8">
                                <option value = '{{$grupos[0]->id}}'>{{$grupos[0]->nombreG}}</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <button class="btn btn-primary" type="submit">Buscar</button>
                            <a class="btn btn-primary" id="button-a">Excel</a>
                        </div>
                    </div>
                </form>
                <script type=text/javascript>
                            $('#organismo').change(function(){
                                var organismoID = $(this).val();
                                if(organismoID){
                                    $.ajax({
                                        type:"GET",
                                        url:"{{url('getGrupo')}}?organismo_id="+organismoID,
                                        success:function(res){
                                            if(res){
                                                $("#grupo").empty();
                                                $("#grupo").append('<option>Grupo no seleccionado</option>');
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
                                }
                            });
                </script>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-sm table-striped" id="mytable">
                <thead>
                    <tr style="font-size: 70%;">
                        <th style="width: 60px;">Cod.interno</th>
                        <th style="width: 60px;">Código REEUP</th>
                        <th style="width: 120px;">Nombre</th>
                        <th style="width: 120px;">Siglas</th>
                        <th style="width: 200px;">Organismo</th>
                        <th style="width: 120px;">Grupo</th>
                        <th style="width: 20px;">Cliente</th>
                        <th style="width: 20px;">Provedor</th>
                        <th style="width: 40px;">Contratos</th>
                        <th style="width: 40px;">Activo</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($cliente_proveedor as $item)
                    <tr style="font-size: 70%;">
                        <td><a href="{{url('clientes_proveedores/'.$item->identidad.'/edit')}}">{{$item->codigo}}</a></td>
                        <td>{{$item->codigoreu}}</td>
                        <td>{{$item->nombre}}</td>
                        <td>{{$item->abreviatura}}</td>
                        @foreach ($GO as $item3)
                            @if ($item3->idClientGO == $item->identidad)
                                <td>{{ $item3->organismos->nombreO }}</td>
                                @break
                            @endif
                        @endforeach
                        @foreach ($GO as $item4)
                            @if ($item4->idClientGO == $item->identidad)
                                <td>{{ $item4->grupos->nombreG }}</td>
                                @break
                            @endif
                        @endforeach
                        @foreach ($CP as $item2)
                            @if ($item2->idClientCP == $item->identidad)
                                <td>{{ $item2->cliente == true ? 'Si' : 'No' }}</td>
                                <td>{{ $item2->proveedor == true ? 'Si' : 'No' }}</td>
                                @break
                            @endif
                        @endforeach
                        <td><a href="{{url('clientes_proveedores/'.$item->identidad)}}"><svg xmlns="http://www.w3.org/2000/svg" style="width: 15%;" viewBox="0 0 384 512"><!-- Font Awesome Free 5.15.3 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) --><path d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34zM332.1 128H256V51.9l76.1 76.1zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288H48z"/></svg></a></td>
                        <td>
                            @if ($item->activo == 1)
                                Activo
                            @else
                                No Activo
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($links)
                {{$cliente_proveedor->links()}}   
            @endif
        </div>
    </div>
    </div>
</div>
@endsection
