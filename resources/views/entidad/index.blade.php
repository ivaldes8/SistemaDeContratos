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
                        Entidades
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <a href="{{ url('entidad-file-import') }}" class="btn btn-primary">Importar Entidades</a>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <a href="{{ url('entidad/create') }}" class="btn btn-primary">Crear Entidad</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('entidad') }}" method="get">
                    <div class="row">
                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="name" class="form-control form-control-sm" placeholder="Nombre" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="siglas" class="form-control form-control-sm" placeholder="Siglas" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="dpa" class="form-control form-control-sm" placeholder="DPA" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="direccion" class="form-control form-control-sm" placeholder="Dirección" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="codREU" class="form-control form-control-sm" placeholder="Código REU" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="codNIT" class="form-control form-control-sm" placeholder="Código NIT" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="codFormOrg" class="form-control form-control-sm"
                                    placeholder="Código de forma organizativa" />
                            </div>
                        </div>

                        <div class="col-3 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input name="formOrg" class="form-control form-control-sm"
                                    placeholder="Forma organizativa" />
                            </div>
                        </div>

                        <div class="col-5 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="org_id" class="form-control form-control-sm orgSelect">
                                    <option></option>
                                    @foreach ($organismos as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}-{{ $item->siglas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-6 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="osde_id" class="form-control form-control-sm osdeSelect">
                                    <option></option>
                                    @foreach ($osdes as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}-{{ $item->siglas }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-1 d-flex justify-content-end my-1">
                            <button class="btn btn-sm btn-primary mx-1" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
            </div>
            </form>
            <hr>
            <div class="table-responsive">
                <table class="table table-primary table-sm table-bordered table-striped">
                    <thead>
                        <tr style="font-size: 90%;">
                            <th style="width: 20px;">ID</th>
                            <th style="width: 100px;">Código REU</th>
                            <th style="width: 80px;">Código NIT</th>
                            <th style="width: 200px;">Nombre</th>
                            <th style="width: 60px;">Siglas</th>
                            <th style="width: 280px;">Dirección</th>
                            <th style="width: 60px;">DPA</th>
                            <th style="width: 180px;">OSDE</th>
                            <th style="width: 120px;">Organismo</th>
                            <th style="width: 120px;">Forma Organizativa</th>
                            <th style="width: 20px;">Cod</th>
                            <th style="width: 60px;">Edit</th>
                            <th style="width: 60px;">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($entidad) < 1)
                            <tr>
                                <td class="text-center" colspan="16">No se encontraron entidades</td>
                            </tr>
                        @else
                            @foreach ($entidad as $item)
                                <tr style="font-size: 90%;">
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->codREU }}</td>
                                    <td>{{ $item->codNIT ? $item->codNIT : '---' }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->siglas ? $item->siglas : '---' }}</td>
                                    <td>{{ $item->direccion ? $item->direccion : '---' }}</td>
                                    <td>{{ $item->dpa ? $item->dpa : '---' }}</td>
                                    <td>{{ $item->osde ? $item->osde->name : '---' }}</td>
                                    <td>{{ $item->organismo ? $item->organismo->name : '---' }}</td>
                                    <td>{{ $item->formOrg ? $item->formOrg : '---' }}</td>
                                    <td>{{ $item->codFormOrg ? $item->codFormOrg : '---' }}</td>
                                    <td>
                                        <a href="{{ url('entidad/' . $item->id . '/edit') }}"
                                            class="btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                    </td>
                                    <td>
                                        <button class="btn-sm btn-danger" data-toggle="modal" id="smallButton"
                                            data-target="#smallModal" data-attr="{{ url('entidad/delete', $item->id) }}"
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
                    {{ $entidad->withQueryString()->links() }}
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
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Entidad</h5>
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
        $('.orgSelect').select2({
            placeholder: "Organismo",
            allowClear: true
        });
        $('.osdeSelect').select2({
            placeholder: "OSDE",
            allowClear: true
        });
    </script>
@endsection
