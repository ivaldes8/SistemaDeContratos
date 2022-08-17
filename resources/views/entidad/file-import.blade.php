@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card bg-light mt-3">

        <div class="card-header">
            <div class="row">
                <div class="col-6 mt-1 d-flex justify-content-start">
                    Importar Entidad
                </div>
                <div class="col-3 d-flex justify-content-end">
                    <a class="btn btn-primary" href="{{url('entidad-file-export')}}">Descargar Plantilla</a>
                </div>
                <div class="col-3 d-flex justify-content-end">
                    <a href="{{url('entidad')}}" class="btn btn-success">Atrás</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ url('entidad-file-import') }}" method="POST" enctype="multipart/form-data">
                @csrf


                @if (count($errors) > 0)
                <div class="row">
                    <div class="col-md-12 col-md-offset-1">
                      <div class="alert alert-danger">
                          <h4><i class="bi-exclamation-triangle"></i> Error!</h4>
                          @foreach($errors->all() as $error)
                          {{ $error }} <br>
                          @endforeach
                      </div>
                    </div>
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-primary" role="alert">
                            <h4><i class="bi-exclamation-circle"></i> Atención:</h4>
                            <p>1-Cada fila del excel será tomada como una entidad a agregar</p>
                            <p>2-Toda fila del excel debe tener un nombre, código reu, código de Osde y código de Organismo</p>
                            <p>3-El código de Osde y el código de Organismo deben pertenecer a Osdes y Organismos existentes en la aplicación</p>
                            <p>4-Las entidades a importar no deben existir en la base de datos</p>
                        </div>
                    </div>
                </div>
                @endif

                @if (Session::has('success'))
                    <div class="row">
                      <div class="col-md-12 col-md-offset-1">
                        <div class="alert alert-success">
                            <h4><i class="bi-check-circle"></i> Excel importado satisfactoriamente</h4>
                        </div>
                      </div>
                    </div>
                @endif

                <input type="file" name="file" class="form-control">
                <br>
                <div class="form-group mb-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Importar</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
