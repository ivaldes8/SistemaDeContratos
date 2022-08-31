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
                        Logs
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <button class="btn-sm btn-danger" data-toggle="modal" id="smallButton" data-target="#smallModal"
                            data-attr="{{ url('logs/delete') }}" title="Delete Project">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('logs') }}" method="get">
                    <div class="row">
                        <div class="col-2 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <select name="action" class="form-control form-control-sm actionSelect">
                                    <option></option>
                                    @foreach ($actions as $item)
                                        <option value="{{ $item }}">{{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <select name="type" class="form-control form-control-sm typeSelect">
                                    <option></option>
                                    @foreach ($types as $item)
                                        <option value="{{ $item }}">{{ $item }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2 mt-1 d-flex justify-content-start">
                            <div class="input-group ">
                                <select name="user_id" class="form-control form-control-sm userSelect">
                                    <option></option>
                                    @foreach ($users as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-2 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input type="text" name="fechaFrom" class="form-control form-control-sm date"
                                    placeholder="Fecha desde" />
                            </div>
                        </div>
                        <div class="col-2 mt-1 d-flex justify-content-start">
                            <div class="input-group">
                                <input type="text" name="fechaTo" class="form-control form-control-sm date"
                                    placeholder="Fecha hasta" />
                            </div>
                        </div>

                        <div class="col-2 d-flex justify-content-end">
                            <a href="{{ url('logs') }}" class="btn btn-sm btn-primary"><i
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
                                <th>User</th>
                                <th>Action</th>
                                <th>Type</th>
                                <th>Element</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($logs) < 1)
                                <tr>
                                    <td class="text-center" colspan="7">No se encontraron Logs</td>
                                </tr>
                            @else
                                @foreach ($logs as $item)
                                    <tr>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->action }}</td>
                                        <td>{{ $item->type }}</td>
                                        <td>{{ $item->element }}</td>
                                        <td>{{ $item->created_at }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="d-flex">
                        {{ $logs->withQueryString()->links() }}
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
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Logs</h5>
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
            $('.actionSelect').select2({
                placeholder: "Action",
                allowClear: true
            });
        });
        $(document).ready(function() {
            $('.typeSelect').select2({
                placeholder: "Type",
                allowClear: true
            });
        });
        $(document).ready(function() {
            $('.userSelect').select2({
                placeholder: "Users",
                allowClear: true
            });
        });
        $('.date').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true,
            clearBtn: true,
            orientation: 'bottom'
        });
    </script>
@endsection
