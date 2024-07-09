@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/show-data.css')}}">
@endsection

@section('content')

    <div class="p-4">
        <h2>{{ $title }}</h2>
        <div class="card">
            <div class="card-body">

                <div class="row row-cols-lg-4 row-cols-md-2  row-cols-1">
    
                    <div class="form-group">
                        <label class="form-input-label" for="nombres">Nombres:</label>
                        <div class="form-input">{{ $cliente->nombre }}</div>
                    </div>
    
                    <div class="form-group">
                        <label class="form-input-label" for="apellidos">Apellidos:</label>
                        <div class="form-input">{{ $cliente->apellido }}</div>
                    </div>

                    <div class="form-group">
                        <label class="form-input-label" for="sexo">Género:</label>
                        <div class="form-input">{{ $cliente->genero === 'M' ? 'Masculino' : 'Femenino' }}</div>
                    </div>

                    <div class="form-group col-lg-2">
                        <label class="form-input-label" for="telefono">Estado Activo:</label>
                        <div class="form-input">{{ $cliente->estado == '1' ? "Activo" : "Inactivo" }}</div>
                    </div>

                </div>

                <hr class="mt-lg-2 mb-lg-0">

                <a 
                    href="{{ route('clientes.index') }}" 
                    class="btn__primary m-lg-4 col-lg-2 col-md-4 text-center">Volver
                </a>
            </div>
        </div>
    </div>
    
@endsection