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
                    <div class="row">
                        <div class="col-12">
                            Grupos
                            <a href="{{url('grupos/create')}}" class="btn btn-primary float-end">
                                Añadir Grupo
                            </a>
                        </div>
                    </div>
                    <br/>
                    <form action="{{ url('grupoSearch') }}"  method="GET">
                        <div class="row">
                            <div class="col-2">
                                Código:<input type="text" class="form-control" name="codigo"/>
                            </div>
                            <div class="col-3">
                                Nombre:<input type="text" class="form-control" name="nombre"/>
                            </div>
                            <div class="col-2">
                                Siglas:<input type="text" class="form-control" name="siglas"/>
                            </div>
                            <div class="col-4">
                                Organismo:
                                <select id="organismo" name="organismo" class="col-8 form-control">
                                    @foreach ( $organismo as $item )
                                    <option value="{{$item->id}}">{{$item->nombreO}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-1">
                                <button class="btn btn-primary mt-4" type="submit">Buscar</button>
                            </div>
                        </div>
                    </form>
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
                                <td>{{$item->codigoG}}</td>
                                <td>{{$item->nombreG}}</td>
                                <td>{{$item->siglasG}}</td>
                                <td>{{$item->organismos->nombreO}}</td>
                                <td>
                                    @if ($item->activoG == 1)
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
