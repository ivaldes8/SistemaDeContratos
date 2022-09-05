@extends('layouts.app')

@section('content')
    <div class="container mt-3">
        <div class="row justify-content-center">
            <div class="col-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-6 mt-1 d-flex justify-content-start">
                        Editar Servicio
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{ url('areaserv') }}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($servicio === 'none')
                    <form action="{{ url('areaserv/' . $serv[0]->idservicio) }}" method="POST">
                    @else
                        <form action="{{ url('areaserv/' . $servicio[0]->id) }}" method="POST">
                            @method('PUT')
                @endif
                @csrf

                <div class="form-group mb-3">
                    <label for="">Código:</label>
                    <input type="text" name="codigo" class="form-control"
                        value="{{ $servicio !== 'none' && $servicio[0] ? $servicio[0]->servicio->codigo : $serv[0]->codigo }}"
                        disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="">Nombre:</label>
                    <input type="text" name="nombre" class="form-control"
                        value="{{ $servicio !== 'none' && $servicio[0] ? $servicio[0]->servicio->Descripcion : $serv[0]->Descripcion }}"
                        disabled>
                </div>

                <div class="form-group mb-3">
                    <label for="">Área:</label>
                    <select name="area_id" class="form-select areaSelect">
                        <option></option>
                        @foreach ($areas as $item)
                            <option {{ $servicio !== 'none' && $item->idarea == $servicio[0]->area_id ? 'selected' : '' }}
                                value="{{ $item->idarea }}">{{ $item->descripcion }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('area_id'))
                        <span class="text-danger">{{ $errors->first('area_id') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3 d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">Editar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.areaSelect').select2({
                placeholder: "Área",
            });
        });
    </script>
@endsection
