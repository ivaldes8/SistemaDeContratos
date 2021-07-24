@extends('layouts.frontend')

@section('content')

<div class="container">
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
                    <h4>Editar Grupo
                    <a href="{{url('grupos')}}" class="btn btn-danger float-end">
                        Atrás
                    </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{url('grupos/' .$grupo->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="">Código</label>
                            <input type="number" name="codigo" class="@error('codigo') is-invalid @enderror form-control" value="{{ $grupo->codigoG }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Nombre</label>
                            <input type="text" name="nombre" class="@error('nombre') is-invalid @enderror form-control" value="{{ $grupo->nombreG }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Siglas</label>
                            <input type="text" name="siglas" class="form-control" value="{{ $grupo->siglasG }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="organismo">Organismo</label>
                            <select class="@error('id_organismo') is-invalid @enderror col-12" style="border: solid 1px;"  value="{{ $grupo->id_Organismo }}" id="organismo" name="id_Organismo">
                            @foreach ( $organismo as $item )
                                <option value="{{$item->id}}"  {{ $item->id == $grupo->id_Organismo ? 'selected' : '' }}>{{$item->nombreO}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Activo</label>
                            <input type="checkbox" name="activo" {{ $grupo->activoG == 1 ? 'checked' : '' }}>
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
