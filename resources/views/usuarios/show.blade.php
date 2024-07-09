@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/show-data.css')}}">
@endsection

@section('content')

    <div class="p-4">
        <div class="d-flex">
            <a 
                href="{{ route('users.index') }}" 
                class="btn__primary mb-auto">Volver
            </a>
            <h2>{{ $title }}</h2>
        </div>
        <div class="card">
            <div class="card-body">

                <div class="row row-cols-lg-4 row-cols-md-2  row-cols-1">
                    <div class="form-group">
                        <label class="form-input-label" for="ci">CI:</label>
                        <div class="form-input">{{ $user->ci }}</div>
                    </div>
    
                    <div class="form-group">
                        <label class="form-input-label" for="ci">NIT:</label>
                        <div class="form-input">{{ $user->nit }}</div>
                    </div>
    
                    <div class="form-group">
                        <label class="form-input-label" for="nombres">Nombres:</label>
                        <div class="form-input">{{ $user->nombre }}</div>
                    </div>
    
                    <div class="form-group">
                        <label class="form-input-label" for="apellidos">Apellidos:</label>
                        <div class="form-input">{{ $user->apellido }}</div>
                    </div>
                </div>

                <span class="mt-4"></span>
                {{-- New Row --}}
                
                <div class="row row-cols-lg-4 row-cols-md-2  row-cols-1">
                    <div class="form-group col-lg-2">
                        <label class="form-input-label" for="sexo">Género:</label>
                        <div class="form-input">{{ $user->genero === 'M' ? 'Masculino' : 'Femenino' }}</div>
                    </div>
    
                    <div class="form-group col-lg-4">
                        <label class="form-input-label" for="direccion">Dirección:</label>
                        <div class="form-input">{{ $user->direccion }}</div>
                    </div>
    
                    <div class="form-group col-lg-4">
                        <label class="form-input-label" for="fecha_nacimiento">Fecha Nacimiento:</label>
                        <div class="form-input">{{ $user->fecha_nacimiento }}</div>
                    </div>
                    
                    <div class="form-group col-lg-2">
                        <label class="form-input-label" for="telefono">Estado Activo:</label>
                        <div class="form-input">{{ $user->estado == '1' ? "Activo" : "Inactivo" }}</div>
                    </div>
                </div>

                <span class="mt-4"></span>
                {{-- New Row --}}

                <div class="row row-cols-lg-4 row-cols-md-2  row-cols-1">
                    <div class="form-group col-lg-2">
                        <label class="form-input-label" for="email">Rol:</label>
                        <div class="form-input">
                            <ul>
                                @foreach ($user->roles as $role)
                                    <li>{{ $role->nombre }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
    
                    <div class="form-group col-lg-4">
                        <label class="form-input-label" for="email">Email:</label>
                        <div class="form-input">{{ $user->email }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection