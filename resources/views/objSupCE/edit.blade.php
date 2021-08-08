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
                    <h4>Editar Objeto de Suplemento de Contrato Específico
                    <a href="{{url('obj_sup_ce')}}" class="btn btn-danger float-end">
                        Atrás
                    </a>
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{url('obj_sup_ce/' .$obj->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="">Objeto</label>
                            <input type="text" name="objeto" class="@error('objeto') is-invalid @enderror form-control" value="{{ $obj->objeto }}">
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
