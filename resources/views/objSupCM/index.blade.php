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
                            Objetos de Suplemento de Contrato Marco
                            <a href="{{url('obj_sup_cm/create')}}" class="btn btn-primary float-end">
                                Añadir Objeto de Suplemento de un Contrato Marco
                            </a>
                        </div>
                    </div>
                    <br/>
                    <form action="{{ url('obj_sub_cm_search') }}"  method="GET">
                        <div class="row">
                            <div class="col-6">
                                Objeto:<input type="text" class="form-control form-control-sm" name="objeto"/>
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
                                <th>id</th>
                                <th>Objeto</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($obj as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->ObjetoSuplementoCM}}</td>
                                <td>
                                   <a href="{{url('obj_sup_cm/'.$item->id.'/edit')}}" class="btn btn-sm btn-primary">Editar</a>
                                </td>
                                <td>
                                   <form action="{{url('obj_sup_cm/'.$item->id)}}" method="POST">
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
                    {{$obj->links()}}   
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
