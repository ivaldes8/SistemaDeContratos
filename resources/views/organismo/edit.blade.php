@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-12">
            @if (session('status'))
                <div class="alert alert-success">{{session('status')}}</div>
            @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6 mt-1 d-flex justify-content-start">
                      {{$organismo === "none" ? 'Crear organismo' : 'Editar organismo'}}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('organismo')}}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            @if($organismo === "none")
                <form action="{{url('organismo')}}" method="POST">
            @else
                <form action="{{url('organismo/'.$organismo->id)}}" method="POST">
                    @method('PUT')
            @endif
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Código:</label>
                        <input type="text" name="codigo" class="form-control" value="{{ $organismo !== 'none' ? $organismo->codigo : '' }}">
                        @if ($errors->has('codigo'))
                            <span class="text-danger">{{ $errors->first('codigo') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Nombre:</label>
                        <input type="text" name="name" class="form-control" value="{{ $organismo !== 'none' ? $organismo->name : '' }}">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="">Siglas:</label>
                        <input type="text" name="siglas" class="form-control" value="{{ $organismo !== 'none' ? $organismo->siglas : '' }}">
                        @if ($errors->has('siglas'))
                            <span class="text-danger">{{ $errors->first('siglas') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">{{$organismo === 'none' ? 'Crear' : 'Editar'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

