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
                        Grupos
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <a href="{{ url('grupo/create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('grupo') }}" method="get">
                    <div class="row">
                        <div class="col-2 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input id="nombre" name="nombre" type="text" class="form-control form-control-sm"
                                    placeholder="Nombre" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-2 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input id="codigo" name="codigo" type="text" class="form-control form-control-sm"
                                    placeholder="Código" aria-describedby="basic-addon1">
                            </div>
                        </div>
                        <div class="col-2 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input type="text" name="siglas" class="form-control form-control-sm" id="siglas"
                                    placeholder="Siglas">
                            </div>
                        </div>
                        <div class="col-4 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <select name="org_id" class="form-control form-control-sm organismoSelect">
                                    <option></option>
                                    @foreach ($organismos as $item)
                                        <option value="{{ $item->id }}">{{ $item->nombre }} / {{ $item->siglas }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-end">
                            <a href="{{ url('grupo') }}" class="btn btn-sm btn-primary"><i
                                    class="bi bi-arrow-repeat"></i></a>
                            <button class="btn btn-sm btn-primary mx-1" type="submit"><i class="bi bi-search"></i></button>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-primary table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 340px;">Nombre</th>
                                <th style="width: 200px;">Siglas</th>
                                <th style="width: 100px;">Código</th>
                                <th style="width: 240px;">Organismo</th>
                                <th style="width: 40px;">Activo</th>
                                <th style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($grupo) < 1)
                                <tr>
                                    <td class="text-center" colspan="7">No se encontraron grupos</td>
                                </tr>
                            @else
                                @foreach ($grupo as $item)
                                    <tr>
                                        <td>{{ $item->nombre }}</td>
                                        <td>{{ $item->siglas }}</td>
                                        <td>{{ $item->codigo }}</td>
                                        <td>{{ $item->organismo->nombre }}</td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" role="switch"
                                                    id="flexSwitchCheckChecked" {{ $item->activo ? 'checked' : '' }}
                                                    disabled>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ url('grupo/' . $item->id . '/edit') }}"
                                                class="btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                            <button class="btn-sm btn-danger" data-toggle="modal" id="smallButton"
                                                data-target="#smallModal" data-attr="{{ url('grupo/delete', $item->id) }}"
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
                        {{ $grupo->withQueryString()->links() }}
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
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Grupo</h5>
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
        // display a modal (small modal)
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
        $(document).ready(function() {
            $('.organismoSelect').select2({
                placeholder: "Organismos",
                allowClear: true
            });
        });
    </script>
@endsection
