@extends('layouts.frontend')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

        @if (session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
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
                                <label for="">Tipo</label>
                                Cliente<input type="checkbox" name="tipo" {!! $CP[0]->cliente == true ? 'checked' : '' !!}>
                                Proveedor<input type="checkbox" name="proveedor" {!! $CP[0]->proveedor == true ? 'checked' : '' !!}>
                            </div>
                        @else
                            <div class="form-group mb-3">
                                <label for="">Tipo</label>
                                <p>Cliente.<input  type="checkbox" name="tipo"></p>
                                <p>Proveedor.<input  type="checkbox" name="proveedor"></p>
                            </div>
                        @endif

                        <div class="form-group mb-3">
                            <label for="">Activo</label>
                            <input type="checkbox" name="activo" disabled {!! $entidad[0]->activo == 1 ? 'checked' : '' !!}>
                        </div>
                        <div class="form-group mb-3">
                            <button class="btn btn-primary" type="submit">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
