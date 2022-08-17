@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card bg-light mt-3">

            <div class="card-header">
                <div class="row">
                    <div class="col-6 mt-1 d-flex justify-content-start">
                        Importar Información
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <a class="btn btn-primary" href="{{ url('informacion-file-export') }}">Descargar Plantilla</a>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <a href="{{ url('informacion') }}" class="btn btn-success">Atrás</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ url('informacion-file-import') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @if (count($errors) > 0)
                        <div class="row">
                            <div class="col-md-12 col-md-offset-1">
                                <div class="alert alert-danger">
                                    <h4><i class="bi-exclamation-triangle"></i> Error!</h4>
                                    @foreach ($errors->all() as $error)
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
                                    <p>1-En la columna indicador del excel debe estar el indicador, la unidad de medida y el tipo de clasificador en el siguite formato: (código del indicador/unidad de medida/clasificador Ej: "Inportaciones/Kg/Cpcu")</p>
                                    <p>2-Los productos con sus códigos cpcu deben existir en la aplicación, y en el excel para poner un producto, se pone su código cpcu o saclap</p>
                                    <p>3-Para introducir entidades, se deben poner el código REU de estas, y también deben de existir en la aplicación</p>
                                    <p>4-Las columnas de fechas deben ser especificadas como: date1->20-01-2022, date2->20-01-2022, date3->20-01-2022 y así sucesivamente, con sus valores(opcionales) debajo pertenecientes a los respectivos productos y entidades </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if (Session::has('success') && !$errors->any())
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
