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
                    Usuarios
                    <a href="{{url('user/create')}}" class="btn btn-primary float-end">
                        Crear Usuario
                    </a>
                </div>

                <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Nombre de Usuario</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($user as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->userName}}</td>
                                <td>{{$item->email}}</td>
                                <td>
                                    @if ($item->role_as == 1)
                                        Admin
                                    @elseif ($item->role_as == 3)
                                        Facturador
                                    @else
                                        Usuario
                                    @endif
                                </td>
                                <td>
                                   <a href="{{url('user/'.$item->id.'/edit')}}" class="btn btn-sm btn-primary">Editar</a>
                                </td>
                                <td>
                                   <form action="{{url('user/'.$item->id)}}" method="POST">
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
