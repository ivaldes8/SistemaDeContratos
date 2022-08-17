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
                        Productos
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <a href="{{ url('producto-file-import') }}" class="btn btn-primary">Importar Productos</a>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <a href="{{ url('producto/create') }}" class="btn btn-primary">Crear Producto</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('producto') }}" method="get">
                    <div class="row">
                        <div class="col-11 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <input type="text" name="desc" class="form-control form-control-sm" id="desc"
                                    placeholder="Descripción del producto">
                            </div>
                        </div>

                        <div class="col-1 d-flex justify-content-end">
                            <button class="btn btn-sm btn-primary mx-1" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <select name="cpcu" class="form-control form-control-sm cpcuSelect">
                                    <option></option>
                                    @foreach ($cpcus as $item)
                                        <option value="{{ $item->id }}">{{ $item->codigo }} {{ $item->desc }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <select name="saclap" class="form-control form-control-sm saclapSelect">
                                    <option></option>
                                    @foreach ($saclaps as $item)
                                        <option value="{{ $item->id }}">{{ $item->codigo }} {{ $item->desc }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-4 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <select name="actividad" class="form-control form-control-sm actSelect">
                                    <option></option>
                                    @foreach ($actividades as $item)
                                        <option value="{{ $item->id }}">{{ $item->desc }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <div class="table-responsive">
                    <table class="table table-primary table-bordered table-striped">
                        <thead>
                            <tr style="font-size: 90%;">
                                <th style="width: 20px;">ID</th>
                                <th style="width: 200px;">Descripción</th>
                                <th style="width: 200px;">CPCU</th>
                                <th style="width: 200px;">SACLAP</th>
                                <th style="width: 200px;">Actividad Industrial</th>
                                <th style="width: 20px;">Editar</th>
                                <th style="width: 20px;">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($producto) < 1)
                                <tr>
                                    <td class="text-center" colspan="10">No se encontraron productos</td>
                                </tr>
                            @else
                                @foreach ($producto as $item)
                                    <tr style="font-size: 90%;">
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->desc }}</td>
                                        <td>
                                            @if (count($item->cpcus) > 0)
                                                @foreach ($item->cpcus as $cpcu)
                                                    / {{ $cpcu->codigo }}
                                                @endforeach
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>
                                            @if (count($item->saclaps) > 0)
                                                @foreach ($item->saclaps as $saclap)
                                                    / {{ $saclap->codigo }}
                                                @endforeach
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>
                                            @if (count($item->actividades) > 0)
                                                @foreach ($item->actividades as $actividad)
                                                    / {{ $actividad->desc }}
                                                @endforeach
                                            @else
                                                ---
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ url('producto/' . $item->id . '/edit') }}"
                                                class="btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                        </td>
                                        <td>
                                            <button class="btn-sm btn-danger" data-toggle="modal" id="smallButton"
                                                data-target="#smallModal"
                                                data-attr="{{ url('producto/delete', $item->id) }}"
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
                        {{ $producto->withQueryString()->links() }}
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
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Producto</h5>
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
        $('.cpcuSelect').select2({
            placeholder: "Código CPCU",
            allowClear: true
        });
        $('.saclapSelect').select2({
            placeholder: "Código SACLAP",
            allowClear: true
        });
        $('.actSelect').select2({
            placeholder: "Actividades Industriales",
            allowClear: true
        });
    </script>
@endsection
