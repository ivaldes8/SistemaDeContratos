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
                    <div class="col-9 mt-1 d-flex justify-content-start">
                        Suplemento de Contrato Proveedor
                    </div>
                    @if ($cp)
                        <div class="col-3 d-flex justify-content-end">
                            <a href="{{ url('supcp/create/' . $cp->id) }}" class="btn btn-primary"><i
                                    class="bi bi-plus-circle"></i></a>
                        </div>
                    @endif

                </div>
            </div>
            <div class="card-body">
                @if ($cp)
                    <div style="font-size: 80%">
                        <p style="margin:0">No.Contrato: {{ $cp->noContrato ? $cp->noContrato : '---' }}</p>
                        <p style="margin:0">Tipo de Contrato: {{ $cp->tipo ? $cp->tipo->nombre : '---' }}</p>
                        <p style="margin:0">Organismo:
                            {{ $cp->grupoOrg && $cp->grupoOrg->organismo ? $cp->grupoOrg->organismo->nombre : '---' }}</p>
                        <p style="margin:0">Grupo:
                            {{ $cp->grupoOrg && $cp->grupoOrg->grupo ? $cp->grupoOrg->grupo->nombre : '---' }}</p>
                        <p style="margin:0">Cliente:
                            {{ $cp->proveedor && $cp->proveedor->entidad ? $cp->proveedor->entidad->nombre : '---' }}</p>
                    </div>
                    <hr>
                @endif

                <form action="{{ $cp ? url('supcp/' . $cp->id) : url('supcp') }}" method="get">
                    <div class="row">
                        <div class="col-6 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input name="noContrato" type="text" class="form-control form-control-sm"
                                    placeholder="No. Contrato" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-6 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input name="noSuplemento" type="text" class="form-control form-control-sm"
                                    placeholder="No. Suplemento" aria-describedby="basic-addon1">
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
                            <a href="{{ $cp ? url('supcp/' . $cp->id) : url('supcp') }}" class="btn btn-sm btn-primary">
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
                    <table class="table table-primary table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 200px;">No. Contrato</th>
                                <th style="width: 200px;">No. Suplemento</th>
                                <th style="width: 400px;">Objeto</th>
                                <th style="width: 340px;">Ejecutor</th>
                                <th style="width: 250px;">Fecha de firma</th>
                                <th style="width: 250px;">Fecha de cierre</th>
                                <th style="width: 300px;">Obervaciones</th>
                                <th style="width: 150px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($supcps) < 1)
                                <tr>
                                    <td class="text-center" colspan="16">
                                        No se encontraron Suplementos de este Contrato Proveedor
                                    </td>
                                </tr>
                            @else
                                @foreach ($supcps as $item)
                                    <tr>
                                        <td>{{ $item->cp ? $item->cp->noContrato : '---' }}</td>
                                        <td>{{ $item->noSupCP }}</td>
                                        <td>
                                            @if (count($item->objetos) > 0)
                                                @foreach ($item->objetos as $objeto)
                                                    / {{ $objeto->nombre }}
                                                @endforeach
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>{{ $item->ejecutor ? $item->ejecutor : '---' }}</td>
                                        <td>{{ $item->fechaIni ? $item->fechaIni : '---' }}</td>
                                        <td>{{ $item->fechaEnd ? $item->fechaEnd : '---' }}</td>
                                        <td>{{ $item->observ ? $item->observ : '---' }}</td>
                                        <td>
                                            <a href="{{ url('supcp/' . $item->id . '/edit') }}"
                                                class="btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                            <button class="btn-sm btn-danger" data-toggle="modal" id="smallButton"
                                                data-target="#smallModal" data-attr="{{ url('supcp/delete', $item->id) }}"
                                                title="Delete Project">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex">
                        {{ $supcps->withQueryString()->links() }}
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
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Suplemento</h5>
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
