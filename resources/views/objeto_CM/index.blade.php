@extends('layouts.frontend')

@section('content')

<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if (session('status'))
            <div class="alert alert-success mb-3">{{session('status')}}</div>
        @endif
            <div class="card">
                <div class="card-header">

                    <div class="row">
                        <div class="col-12">
                            Tipos de Contratos
                            <a href="{{url('objeto_CM/create')}}" class="btn btn-primary float-end">
                                Añadir Tipo de Contrato
                            </a>
                        </div>
                    </div>
                    <br/>
                    <form action="{{ url('objetoCMSearch') }}"  method="GET">
                        <div class="row">
                            <div class="col-3">
                                Nombre:<input type="text" class="form-control" name="obj"/>
                            </div>
                            <div class="col-3">
                            </div>
                            <div class="col-3">
                            </div>
                            <div class="col-2">
                            </div>
                            <div class="col-1">
                                <button class="btn btn-primary mt-4" type="submit">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-sm table-striped   ">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($objeto as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->nombre}}</td>
                                <td>
                                   <a href="{{url('objeto_CM/'.$item->id.'/edit')}}" class="btn btn-sm btn-primary">Editar</a>
                                </td>
                                <td>
                                   <form action="{{url('objeto_CM/'.$item->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                   </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @if ($links)
                    {{$objeto->links()}}   
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
