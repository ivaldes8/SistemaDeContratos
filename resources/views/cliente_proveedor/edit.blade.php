@extends('layouts.frontend')

@section('content')
<script src="{{ asset('frontend/js/ajaxjquery.js') }}"></script>
<script src="{{ asset('frontend/js/ajaxpropper.js') }}"></script>
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">

        @if (session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
        @endif
        @if (count($errors) > 0)
            <ul class="alert alert-danger pl-5 mt-3 mb-3">
	            @foreach($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
            </ul>
        @endif
            <div class="card">
                <div class="card-header">
                    <h4>Editar Entidad
                    <a href="{{url('clientes_proveedores')}}" class="btn btn-danger float-end">
                        Atrás
                    </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{url('clientes_proveedores/' .$entidad[0]->identidad)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="">Código interno</label>
                            <p class="form-control">{{ $entidad[0]->codigo }}
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Código REEUP</label>
                            <p class="form-control">{!! $entidad[0]->codigoreu ? $entidad[0]->codigoreu : '-' !!}</p>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Nombre</label>
                            <p class="form-control">{!! $entidad[0]->nombre ? $entidad[0]->nombre : '-' !!}</p>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Siglas</label>
                            <p class="form-control">{!! $entidad[0]->abreviatura ? $entidad[0]->abreviatura : '-' !!}</p>
                        </div>
                        @if (count($CP)>0)
                            <div class="form-group mb-3">
                                <label for="">Tipo:</label>
                                <p>Cliente<input type="checkbox" name="tipo" {!! $CP[0]->cliente == true ? 'checked' : '' !!}></p>
                                <p>Proveedor<input type="checkbox" name="proveedor" {!! $CP[0]->proveedor == true ? 'checked' : '' !!}></p>
                            </div>
                        @else
                            <div class="form-group mb-3">
                                <label for="">Tipo:</label>
                                <p>Cliente.<input  type="checkbox" name="tipo"></p>
                                <p>Proveedor.<input  type="checkbox" name="proveedor"></p>
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <label for="state">Organismo:</label>
                            <select id="organismo" name="organismo_id" class="@error('organismo_id') is-invalid @enderror col-8">
                                <option value="" selected disabled>Seleccione un Organismo:</option>
                                @foreach($organismos as $organismo)
                                <option value="{{$organismo->id}}" {{ $organismo->id == $GO[0] -> idOrganismo ? 'selected' : '' }} > {{$organismo->nombreO}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="grupo">Seleccione un Grupo:</label>
                            <select name="grupo" id="grupo" class="col-8">
                                <option value = '{{$GO[0]->grupos->id}}'>{{$GO[0]->grupos->nombreG}}</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Activo</label>
                            <input type="checkbox" name="activo" disabled {{ $entidad[0]->activo == 1 ? 'checked' : '' }}>
                        </div>
                        <div class="form-group mb-3">
                            <button class="btn btn-primary" type="submit">Actualizar</button>
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
            </div>
        </div>
    </div>
</div>
@endsection
