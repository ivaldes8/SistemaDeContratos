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
                        {{ $supcp === 'none' ? 'Crear Suplemento' : 'Editar Suplemento' }}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{ url()->previous() }}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($supcp === 'none')
                    <form action="{{ url('supcp/' . $id) }}" method="POST">
                    @else
                        <form action="{{ url('supcp/' . $supcp->id) }}" method="POST">
                            @method('PUT')
                @endif
                @csrf
                <div class="form-group mb-3">
                    <label for="">No. Suplemento:</label>
                    <input type="text" name="noSuplemento" class="form-control"
                        value="{{ $supcp !== 'none' ? $supcp->noSupCP : '' }}" disabled>
                    @if ($errors->has('noSuplemento'))
                        <span class="text-danger">{{ $errors->first('noSuplemento') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label class="mx-2" for="">Objeto:</label>
                    <select name="objeto_id[]" multiple="multiple" class="form-control objetoSelect">
                        <option></option>
                        @foreach ($objetos as $item)
                            <option
                                {{ $supcp !== 'none' && !!$supcp->objetos->where('id', $item->id)->first() ? 'selected' : '' }}
                                value="{{ $item->id }}">{{ $item->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('objeto_id'))
                        <span class="text-danger">{{ $errors->first('objeto_id') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3">
                    <label for="">Ejecutor:</label>
                    <input type="text" name="ejecutor" class="form-control"
                        value="{{ $supcp !== 'none' ? $supcp->ejecutor : '' }}">
                    @if ($errors->has('ejecutor'))
                        <span class="text-danger">{{ $errors->first('ejecutor') }}</span>
                    @endif
                </div>

                <div class="row">
                    <div class="col-6">
                        <label for="">Fecha de firma:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-calendar-date"></i>
                            </span>
                            <input type="text" name="fechaIni" class="form-control date"
                                value="{{ $supcp !== 'none' ? $supcp->fechaIni : '' }}" id="picker1">
                            @if ($errors->has('fechaIni'))
                                <span class="text-danger">{{ $errors->first('fechaIni') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <label for="">Fecha de vencimiento:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-calendar-date"></i>
                            </span>
                            <input type="text" name="fechaEnd" class="form-control date"
                                value="{{ $supcp !== 'none' ? $supcp->fechaEnd : '' }}" id="picker2">
                            @if ($errors->has('fechaEnd'))
                                <span class="text-danger">{{ $errors->first('fechaEnd') }}</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="">Observaciones:</label>
                    <textarea class="form-control" name="observ">
                        {{ $supcp !== 'none' ? $supcp->observ : '' }}
                    </textarea>
                    @if ($errors->has('observ'))
                        <span class="text-danger">{{ $errors->first('observ') }}</span>
                    @endif
                </div>

                <div class="form-group mb-3 d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">{{ $supcp === 'none' ? 'Crear' : 'Editar' }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.objetoSelect').select2({
                placeholder: "Objeto",
            });
        });
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,
            orientation: 'bottom'
        });
    </script>
@endsection
