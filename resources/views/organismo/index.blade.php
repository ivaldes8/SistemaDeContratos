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
                            Organismos
                            <a href="{{url('organismos/create')}}" class="btn btn-primary float-end">
                                Añadir Organismo
                            </a>
                        </div>
                    </div>
                    <br/>
                    <form action="{{ url('organismoSearch') }}"  method="GET">
                        <div class="row">
                            <div class="col-3">
                                Código:<input type="text" class="form-control" name="codigo"/>
                            </div>
                            <div class="col-3">
                                Nombre:<input type="text" class="form-control" name="nombre"/>
                            </div>
                            <div class="col-3">
                                Siglas:<input type="text" class="form-control" name="siglas"/>
                            </div>
                            <div class="col-2">
                                Activo:
                                <select id="organismo" name="activo" class="col-8 form-control">
                                    <option value="" selected >Todos</>
                                    <option value="1" >Activo</>
                                    <option value="0" >No Activo</>
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
                                <th>Activo</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($organismo as $item)
                            <tr>
                                <td>{{$item->codigoO}}</td>
                                <td>{{$item->nombreO}}</td>
                                <td>{{$item->siglasO}}</td>
                                <td>
                                    @if ($item->activoO == 1)
                                        Activo
                                    @else
                                        No Activo
                                    @endif
                                </td>
                                <td>
                                   <a href="{{url('organismos/'.$item->id.'/edit')}}" class="btn btn-sm btn-primary">Editar</a>
                                </td>
                                <td>
                                   <form action="{{url('organismos/'.$item->id)}}" method="POST">
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
