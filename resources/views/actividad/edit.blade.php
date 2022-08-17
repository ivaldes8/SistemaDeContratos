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
                      {{$actividad === "none" ? 'Crear actividad industrial' : 'Editar actividad industrial'}}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{url('actividad')}}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
            @if($actividad === "none")
                <form action="{{url('actividad')}}" method="POST">
            @else
                <form action="{{url('actividad/'.$actividad->id)}}" method="POST">
                    @method('PUT')
            @endif
                    @csrf
                    <div class="form-group mb-3">
                        <label for="">Código</label>
                        <input type="text" name="codigo" class="form-control" value="{{ $actividad !== 'none' ? $actividad->codigo : '' }}">
                        @if ($errors->has('codigo'))
                            <span class="text-danger">{{ $errors->first('codigo') }}</span>
                        @endif
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Descripción:</label>
                        <input type="text" name="desc" class="form-control" value="{{ $actividad !== 'none' ? $actividad->desc : '' }}">
                        @if ($errors->has('desc'))
                            <span class="text-danger">{{ $errors->first('desc') }}</span>
                        @endif
                    </div>

                    <div class="form-group mb-3 d-flex justify-content-end">
                        <button class="btn btn-primary" type="submit">{{$actividad === 'none' ? 'Crear' : 'Editar'}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

