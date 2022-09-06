@extends('layouts.app')

@section('content')
    <div class="mx-5 mt-3">
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
                    <div class="col-9 mt-1 d-flex justify-content-start">
                        Contratos Específicos de Contrato Marco
                    </div>
                    @if ($cm)
                        <div class="col-3 d-flex justify-content-end">
                            <a href="{{ url('ce/create/' . $cm->id) }}" class="btn btn-primary"><i
                                    class="bi bi-plus-circle"></i></a>
                        </div>
                    @endif

                </div>
            </div>
            <div class="card-body">
                @if ($cm)
                    <div style="font-size: 80%">
                        <p style="margin:0">No.Contrato: {{ $cm->noContrato ? $cm->noContrato : '---' }}</p>
                        <p style="margin:0">Tipo de Contrato: {{ $cm->tipo ? $cm->tipo->nombre : '---' }}</p>
                        <p style="margin:0">Organismo:
                            {{ $cm->grupoOrg && $cm->grupoOrg->organismo ? $cm->grupoOrg->organismo->nombre : '---' }}</p>
                        <p style="margin:0">Grupo:
                            {{ $cm->grupoOrg && $cm->grupoOrg->grupo ? $cm->grupoOrg->grupo->nombre : '---' }}</p>
                        <p style="margin:0">Cliente:
                            {{ $cm->cliente && $cm->cliente->entidad ? $cm->cliente->entidad->nombre : '---' }}</p>
                    </div>
                    <hr>
                @endif

                <form action="{{ $cm ? url('ce/' . $cm->id) : url('ce') }}" method="get">
                    <div class="row">

                        <div class="col-2 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input name="noContratoEsp" type="text" class="form-control form-control-sm"
                                    placeholder="No. Contrato Esp" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-2 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input name="noContrato" type="text" class="form-control form-control-sm"
                                    placeholder="No. Contrato" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-2 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="codigo" class="form-control form-control-sm" placeholder="Código interno" />
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="codigoreu" class="form-control form-control-sm" placeholder="Código REU" />
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="codigoserv" class="form-control form-control-sm"
                                    placeholder="Código de Servicio" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="area_id" class="form-control form-control-sm areaSelect" id="area">
                                    <option></option>
                                    @foreach ($areas as $item)
                                        <option value="{{ $item->idarea }}">{{ $item->descripcion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="servicio_id" class="form-control form-control-sm servSelect" id="servicio">
                                    <option></option>
                                    @foreach ($servicios as $item)
                                        <option value="{{ $item->idservicio }}">{{ $item->Descripcion }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="estado_id" class="form-control form-control-sm estadoSelect">
                                    <option></option>
                                    @foreach ($estados as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="org_id" class="form-control form-control-sm orgSelect" id="organismo">
                                    <option></option>
                                    @foreach ($organismos as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}-{{ $item->siglas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="grupo_id" class="form-control form-control-sm grupoSelect" id="grupo">
                                    <option></option>
                                    @foreach ($grupos as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }}-{{ $item->siglas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="cliente_id" class="form-control form-control-sm clienteSelect" id="cliente">
                                    <option></option>
                                    @foreach ($clientes as $item)
                                        <option value="{{ $item->identidad }}">
                                            {{ $item->nombre }}-{{ $item->abreviatura }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input type="text" name="fechaIniFrom" class="form-control form-control-sm date"
                                    placeholder="Fecha de firma desde" />
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input type="text" name="fechaIniTo" class="form-control form-control-sm date"
                                    placeholder="Fecha de firma hasta" />
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input type="number" name="montoFrom" class="form-control form-control-sm"
                                    placeholder="Monto desde" />
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input type="number" name="montoTo" class="form-control form-control-sm"
                                    placeholder="Monto hasta" />
                            </div>
                        </div>
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input type="text" name="fechaEndFrom" class="form-control form-control-sm date"
                                    placeholder="Fecha de venc. desde" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input type="text" name="fechaEndTo" class="form-control form-control-sm date"
                                    placeholder="Fecha de venc. hasta" />
                            </div>
                        </div>

                        <div class="col-12 d-flex justify-content-center my-2">
                            <button class="btn btn-sm btn-primary mx-1" disabled>
                                <i class="bi bi-file-earmark-excel"></i>
                            </button>
                            <a href="{{ $cm ? url('ce/' . $cm->id) : url('ce') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-arrow-repeat"></i>
                            </a>
                            <button class="btn btn-sm btn-primary mx-1" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table  table-sm table-bordered table-striped">
                        <thead>
                            <tr style="font-size: 80%;">
                                <th style="width: 200px;">No. Contrato</th>
                                <th style="width: 200px;">No. Contrato Específico</th>
                                <th style="width: 400px;">Tipo</th>
                                <th style="width: 340px;">Servicios</th>
                                <th style="width: 340px;">Área</th>
                                <th style="width: 250px;">Estado</th>
                                <th style="width: 250px;">Ejecutor</th>
                                <th style="width: 250px;">Cliente</th>
                                <th style="width: 250px;">Fecha de firma</th>
                                <th style="width: 250px;">Fecha de cierre</th>
                                <th style="width: 250px;">Monto</th>
                                <th style="width: 300px;">Obervaciones</th>
                                <th style="width: 100px;">Suplementos</th>
                                <th style="width: 300px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($ces) < 1)
                                <tr>
                                    <td class="text-center" colspan="16">
                                        No se encontraron Contratos Específicos de este Contrato Marco
                                    </td>
                                </tr>
                            @else
                                @foreach ($ces as $item)
                                    <tr class="{{ (\Carbon\Carbon::parse($item->fechaVenc)->addMonth(3)->lte($now)? 'bg-warning': \Carbon\Carbon::parse($item->fechaVenc)->lte($now))? 'bg-danger': '' }}"
                                        style="font-size: 70%">
                                        <td>{{ $item->cm ? $item->cm->noContrato : '---' }}</td>
                                        <td>{{ $item->noCE }}</td>
                                        <td>{{ $item->cm && $item->cm->tipo ? $item->cm->tipo->nombre : '---' }}</td>
                                        <td>
                                            @if (count($item->servicios) > 0)
                                                @foreach ($item->servicios as $servicio)
                                                    / {{ $servicio->servicio->Descripcion }}
                                                @endforeach
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>
                                            {{ $item->area ? $item->area->descripcion : '---' }}
                                        </td>
                                        <td>
                                            {{ $item->estado ? $item->estado->nombre : '---' }}
                                        </td>
                                        <td>{{ $item->ejecutor ? $item->ejecutor : '---' }}</td>
                                        <td>{{ $item->cliente ? $item->cliente : '---' }}</td>
                                        <td>{{ $item->fechaFirma ? $item->fechaFirma : '---' }}</td>
                                        <td>{{ $item->fechaVenc ? $item->fechaVenc : '---' }}</td>
                                        <td>{{ $item->observ ? $item->observ : '---' }}</td>
                                        <td>{{ $item->monto ? $item->monto : '---' }}</td>
                                        <td>
                                            <a style="font-weight: bold;font-size: 180%"
                                                href="{{ url('supce/' . $item->id) }}">
                                                <i class="bi bi-file-earmark-plus"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ url('ce/' . $item->id . '/edit') }}"
                                                class="btn-sm btn-primary"><i class="bi bi-pencil"></i></a>

                                            @if (Auth::user()->role === 'Administrador')
                                                <button class="btn-sm btn-danger" data-toggle="modal" id="smallButton"
                                                    data-target="#smallModal"
                                                    data-attr="{{ url('ce/delete', $item->id) }}" title="Delete Project">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex">
                        {{ $ces->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- small modal -->
    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Contrato Específico</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="smallBody">
                    <div>
                        <!-- the result to be displayed apply here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.date').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true,
            clearBtn: true,
            orientation: 'bottom'
        });
        $('.date').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true,
            clearBtn: true,
            orientation: 'bottom'
        });
        $('.orgSelect').select2({
            placeholder: "Organismo",
            allowClear: true
        });
        $('.grupoSelect').select2({
            placeholder: "Grupo",
            allowClear: true
        });
        $('.clienteSelect').select2({
            placeholder: "Cliente",
            allowClear: true
        });
        $('.estadoSelect').select2({
            placeholder: "Estado",
            allowClear: true
        });
        $('.servSelect').select2({
            placeholder: "Servicio",
            allowClear: true
        });
        $('.areaSelect').select2({
            placeholder: "Área",
            allowClear: true
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

        $('#organismo').change(function() {
            var organismoID = $(this).val();
            if (organismoID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('GrupoByOrganismo') }}?org_id=" + organismoID,
                    success: function(res) {
                        if (res) {
                            $("#grupo").empty();
                            $("#grupo").append("<option value='@'>Grupo no seleccionado</option>");
                            $.each(res, function(key, value) {
                                $("#grupo").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });

                        } else {
                            $("#grupo").empty();
                        }
                    }
                });
            } else {
                $("#grupo").empty();
                $("#cliente").empty();
            }
        });

        $('#organismo').change(function() {
            var organismoID = $(this).val();
            if (organismoID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('ClienteByOrganismo') }}?org_id=" + organismoID,
                    success: function(res) {
                        if (res) {
                            $("#cliente").empty();
                            $("#cliente").append("<option value='@'>Cliente no seleccionado</option>");
                            $.each(res, function(key, value) {
                                $("#cliente").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });

                        } else {
                            $("#cliente").empty();
                        }
                    }
                });
            } else {
                $("#grupo").empty();
                $("#cliente").empty();
            }
        });

        $('#grupo').on('change', function() {
            var grupoID = $(this).val();
            if (grupoID) {
                $.ajax({
                    type: "GET",
                    url: "{{ url('ClienteByGrupo') }}?grupo_id=" + grupoID,
                    success: function(res) {
                        if (res) {
                            $("#cliente").empty();
                            $("#cliente").append("<option value='@'>Cliente no seleccionado</option>");
                            $.each(res, function(key, value) {
                                $("#cliente").append('<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        } else {
                            $("#cliente").empty();
                        }
                    }
                });
            } else {
                $("#cliente").empty();
            }
        });

        $(document).on('click', '#smallButton', function(event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function() {
                    $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#smallModal').modal("show");
                    $('#smallBody').html(result).show();
                },
                complete: function() {
                    $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });
    </script>
@endsection
