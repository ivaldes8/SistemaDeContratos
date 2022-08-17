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
                        Grado de Satisfacción de la Demanda Nacional (Cuota de Mercado)
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('cuotaDeMercado') }}" method="get">
                    <div class="row">
                        <div class="col-3 d-flex justify-content-start">
                            <div class="input-group">
                                <span class="btn bi-calendar" id="basic-addon1"></span>
                                <input id="startDate" name="startDate" type="text" class="form-control startDate"
                                    placeholder="Fecha desde" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-3 d-flex justify-content-start">
                            <div class="input-group">
                                <span class="btn bi-calendar-range" id="basic-addon1"></span>
                                <input id="endDate" name="endDate" type="text" class="form-control endDate"
                                    placeholder="Fecha hasta" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <button class="btn btn-primary mx-1" type="submit">Calcular</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 d-flex mt-3 justify-content-start">
                            <div class="input-group">
                                <select name="actividades[]" multiple="multiple" class="form-select actSelect">
                                    @foreach ($actividad as $item)
                                        <option value="{{ $item->id }}">{{ $item->desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="row">
                    @if (count($actArr) > 0 && count($errors) === 0)
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h3><i class="bi-check-circle"></i> Resultado:</h3>
                                @foreach ($actArr as $key => $act)
                                    <h4><i class="bi-caret-right-square"></i>
                                        {{ $act[0][5] }}
                                    </h4>
                                    @foreach ($act as $value)
                                        <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <p style="margin-left: 10px"><i class="bi-caret-right"></i>{{$value[3]}}</p>
                                        </div>
                                        <div class="col-md-12 col-xs-12">
                                            <p style="margin-left: 20px"><i class="bi-arrow-right-short"></i> Produccion: {{$value[0]}} U - Importaciones: {{$value[1]}} U - Cuota de Mercado: {{$value[2]}}% (U)</p>
                                            <p style="margin-left: 20px"><i class="bi-arrow-right-short"></i> Produccion: {{$value[6]}} Valor - Importaciones: {{$value[7]}} Valor - Cuota de Mercado: {{$value[8]}}% (V)</p>
                                        </div>
                                        </div>
                                    @endforeach

                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if (count($errors) > 0)
                        <div class="row">
                            <div class="col-md-12 col-md-offset-1">
                                <div class="alert alert-danger">
                                    <h4><i class="bi-exclamation-triangle"></i> Error!</h4>
                                    @foreach ($errors->all() as $error)
                                        {{ $error }} <br>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.actSelect').select2({
                placeholder: "Actividades Industriales",
                allowClear: true
            });
            $('.startDate').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                autoclose: true,
                orientation: 'bottom'
            });
            $('.endDate').datepicker({
                format: 'dd/mm/yyyy',
                todayHighlight: true,
                autoclose: true,
                orientation: 'bottom'
            });
        });
    </script>
@endsection
