@extends('layouts.frontend')

@section('content')

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if (session('status'))
            <div class="alert alert-success">{{session('status')}}</div>
        @endif
            <div class="card">
                <div class="card-header">
                    Grupos
                    <a href="{{url('grupos/create')}}" class="btn btn-primary float-end">
                        Añadir Grupo
                    </a>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>Siglas</th>
                                <th>Organismo</th>
                                <th>Activo</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($grupo as $item)
                            <tr>
                                <td>{{$item->codigo}}</td>
                                <td>{{$item->nombre}}</td>
                                <td>{{$item->siglas}}</td>
                                <td>{{$item->organismos->nombre}}</td>
                                <td>
                                    @if ($item->activo == 1)
                                        Activo
                                    @else
                                        No Activo
                                    @endif
                                </td>
                                <td>
                                   <a href="{{url('grupos/'.$item->id.'/edit')}}" class="btn btn-sm btn-primary">Editar</a>
                                </td>
                                <td>
                                   <form action="{{url('grupos/'.$item->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                   </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
