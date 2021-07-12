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
                    <h4>Añadir Organismo
                    <a href="{{url('organismos')}}" class="btn btn-danger float-end">
                        Atrás
                    </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{url('organismos')}}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="">Código</label>
                            <input type="number" name="codigo" class="@error('codigo') is-invalid @enderror form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Nombre</label>
                            <input type="text" name="nombre" class="@error('nombre') is-invalid @enderror form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Siglas</label>
                            <input type="text" name="siglas" class="form-control">
                        </div>
                        <div class="form-group mb-3">
                            <label for="">Activo</label>
                            <input type="checkbox" name="activo" checked>
                        </div>
                        <div class="form-group mb-3">
                            <button class="btn btn-primary" type="submit">Crear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
