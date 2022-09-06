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
                        {{ $ce === 'none' ? 'Crear Contrato Específico' : 'Editar Contrato Específico' }}
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{ url()->previous() }}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($ce === 'none')
                    <form action="{{ url('ce/' . $id) }}" method="POST">
                    @else
                        <form action="{{ url('ce/' . $ce->id) }}" method="POST">
                            @method('PUT')
                @endif
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div style="font-size: 80%">
                            <p style="margin:0">No.Contrato: {{ $cm->noContrato ? $cm->noContrato : '---' }}</p>
                            <p style="margin:0">Tipo de Contrato: {{ $cm->tipo ? $cm->tipo->nombre : '---' }}</p>
                            <p style="margin:0">
                                Organismo:{{ $cm->grupoOrg && $cm->grupoOrg->organismo ? $cm->grupoOrg->organismo->nombre : '---' }}
                            </p>
                            <p style="margin:0">
                                Grupo:{{ $cm->grupoOrg && $cm->grupoOrg->grupo ? $cm->grupoOrg->grupo->nombre : '---' }}
                            </p>
                            <p style="margin:0">
                                Cliente:{{ $cm->cliente && $cm->cliente->entidad ? $cm->cliente->entidad->nombre : '---' }}
                            </p>
                        </div>
                        <hr>
                        <div class="form-group mb-3">
                            <label for="">Nombre del prestador:</label>
                            <input type="text" name="ejecutor" class="form-control"
                                value="{{ $ce !== 'none' ? $ce->ejecutor : '' }}">
                            @if ($errors->has('ejecutor'))
                                <span class="text-danger">{{ $errors->first('ejecutor') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Nombre del cliente:</label>
                            <input type="text" name="cliente" class="form-control"
                                value="{{ $ce !== 'none' ? $ce->cliente : '' }}">
                            @if ($errors->has('cliente'))
                                <span class="text-danger">{{ $errors->first('cliente') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label class="mx-2" for="">Estado:</label>
                            <select name="estado_id" class="form-control estadoSelect">
                                <option></option>
                                @foreach ($estados as $item)
                                    <option {{ $ce !== 'none' && $item->id == $ce->estado_c_e_id ? 'selected' : '' }}
                                        value="{{ $item->id }}">{{ $item->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('estado_id'))
                                <span class="text-danger">{{ $errors->first('estado_id') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Monto:</label>
                            <input type="number" step="0.001" class="form-control"
                                value="{{ $ce !== 'none' ? $ce->monto : '' }}" name="monto">
                            @if ($errors->has('monto'))
                                <span class="text-danger">{{ $errors->first('monto') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Observaciones:</label>
                            <textarea class="form-control" name="observ">
                                {{ $ce !== 'none' ? $ce->observ : '' }}
                            </textarea>
                            @if ($errors->has('observ'))
                                <span class="text-danger">{{ $errors->first('observ') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mb-3">
                            <label for="">No. CE:</label>
                            <input type="text" name="noCE" class="form-control"
                                value="{{ $ce !== 'none' ? $ce->noCE : '' }}" disabled>
                            @if ($errors->has('noCE'))
                                <span class="text-danger">{{ $errors->first('noCE') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Fecha de firma del Contrato Marco:</label>
                            <input type="text" name="noCE" class="form-control date"
                                value="{{ $cm ? $cm->fechaFirma : '' }}" disabled>
                        </div>
                        <label for="">Fecha de firma:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-calendar-date"></i>
                            </span>
                            <input type="text" name="fechaIni" class="form-control date"
                                value="{{ $ce !== 'none' ? $ce->fechaFirma : '' }}" id="picker2">
                            @if ($errors->has('fechaIni'))
                                <span class="text-danger">{{ $errors->first('fechaIni') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label for="">Fecha de vencimiento del Contrato Marco:</label>
                            <input type="text" class="form-control date" value="{{ $cm ? $cm->fechaVenc : '' }}"
                                disabled>
                        </div>
                        <label for="">Fecha de vencimiento:</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">
                                <i class="bi bi-calendar-date"></i>
                            </span>
                            <input type="text" name="fechaEnd" class="form-control date"
                                value="{{ $ce !== 'none' ? $ce->fechaVenc : '' }}" id="picker2">
                            @if ($errors->has('fechaEnd'))
                                <span class="text-danger">{{ $errors->first('fechaEnd') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label class="mx-2" for="">Área:</label>
                            <select name="area_id" class="form-control areaSelect" id="area">
                                <option></option>
                                @foreach ($areas as $item)
                                    <option {{ $ce !== 'none' && $item->idarea == $ce->area_id ? 'selected' : '' }}
                                        value="{{ $item->idarea }}">{{ $item->descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('area_id'))
                                <span class="text-danger">{{ $errors->first('area_id') }}</span>
                            @endif
                        </div>

                        <div class="form-group mb-3">
                            <label class="mx-2" for="">Servicios:</label>
                            <select name="serv_id[]" multiple="multiple" class="form-control servicioSelect" id="servicio">
                                <option></option>
                                @foreach ($servicios as $item)
                                    <option
                                        {{ $ce !== 'none' && !!$ce->servicios->where('serv_id', $item->idservicio)->first() ? 'selected' : '' }}
                                        value="{{ $item->idservicio }}">{{ $item->Descripcion }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('serv_id'))
                                <span class="text-danger">{{ $errors->first('serv_id') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3 d-flex justify-content-end">
                    <button class="btn btn-primary" type="submit">{{ $ce === 'none' ? 'Crear' : 'Editar' }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.estadoSelect').select2({
                placeholder: "Estado",
            });
        });
        $('.areaSelect').select2({
            placeholder: "Área",
            allowClear: true
        });
        $(document).ready(function() {
            $('.servicioSelect').select2({
                placeholder: "Servicio",
            });
        });
        $('.date').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,
            orientation: 'bottom'
        });
        $('#area').change(function() {
            var areaID = $(this).val();
            if (areaID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('servByArea') }}?area_id=" + areaID,
                    success: function(res) {
                        if (res) {
                            $("#servicio").empty();
                            $("#servicio").append(
                                "<option value='@'>Servicio no seleccionado</option>");
                            $.each(res, function(key, value) {
                                $("#servicio").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });

                        } else {
                            $("#servicio").empty();
                        }
                    }
                });
            } else {
                $("#servicio").empty();
            }
        });
    </script>
@endsection
