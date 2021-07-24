@extends('layouts.frontend')

@section('content')

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-8">

        @if (session('status'))
            <div class="mt-3 mb-3 alert alert-success">{{session('status')}}</div>
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
                    <h4>Editar Servicio
                    <a href="{{url('servicio_area')}}" class="btn btn-danger float-end">
                        Atrás
                    </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{url('servicio_area/' .$servicio[0]->idservicio)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="">Código</label>
                            <input name="codigo" disabled class="form-control" value="{{ $servicio[0]->codigo }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Nombre</label>
                            <input type="text" name="nombre" disabled  class="form-control" value="{{ $servicio[0]->Expr3}}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Área</label>
                            <select class="col-12" style="border: solid 1px;" name="idArea">
                                @foreach ( $area as $item )
                                    <option value="{{$item->idarea}}"  {{ $item->idarea == $entidadAS[0]->idArea ? 'selected' : '' }}>{{$item->Expr4}}</option>
                                @endforeach
                            </select>
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
