@extends('layout')

@section('content')
    <div class="p-lg-4">
        <h2>{{ $user->nombre . " " . $user->apellido}}</h2>
        <form 
            action="{{route('users.update', $user)}}" 
            method="POST"
            enctype="multipart/form-data" class="row"
        >
            
            @csrf
            @method("PUT")

            <input
                hidden="true"
                type="text" 
                class="form-control"
                id="id" 
                name="id" 
                value="{{ $user->id }}" required
            >

            <div class="row row-cols-lg-4 row-cols-md-2 row-cols-1">
                <div class="form-group mb-4 mb-lg-0">
                    <label for="ci">CI:</label>
                    <input type="text" class="form-control @error('ci') is-invalid @enderror" id="ci" name="ci" value="{{ $user->ci }}" required>
                    @error('ci')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4 mb-lg-0">
                    <label for="nit">NIT:</label>
                    <input type="text" class="form-control @error('nit') is-invalid @enderror" id="nit" name="nit" value="{{ $user->nit }}" required>
                    @error('nit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4 mb-lg-0">
                    <label for="nombre">Nombres:</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ $user->nombre }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="apellido">Apellidos:</label>
                    <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ $user->apellido }}" required>
                    @error('apellido')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <span class="mt-4"></span>
            {{-- New Row --}}

            <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1">
                <div class="form-group  mb-4 mb-lg-0">
                    <label for="genero">Genero:</label>
                    <select class="form-control @error('genero') is-invalid @enderror" id="genero" name="genero" required>
                        <option value="M" {{ $user->genero === 'M' ? 'selected' : '' }}>Masculino</option>

                        <option value="F" {{ $user->genero === 'F' ? 'selected' : '' }}>Femenino</option>
                    </select>
                    @error('genero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group  mb-4 mb-lg-0">
                    <label for="direccion">Dirección:</label>
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" value="{{ $user->direccion }}" required>
                    @error('direccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <span class="mt-4"></span>
            {{-- New row --}}

            <div class="row row-cols-lg-3 row-cols-md-2 row-cols-1">
                <div class="form-group mb-4 mb-lg-0">
                    <label for="estado">Estado Activo:</label>
                    <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                        <option value="1" {{ $user->estado == 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ $user->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4 mb-lg-0">
                    <label for="rol">Rol:</label>
                    <select class="form-control @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                        @foreach ($roles as $rol)
                            <option 
                                value="{{ $rol->nombre }}"
                                {{ $user->rol === $rol->nombre ? 'selected' : '' }}
                                >{{$rol->nombre}}
                            </option>
                        @endforeach
                    </select>
                    @error('rol')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="mail">Email:</label>
                    <input type="mail" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <span class="mt-4"></span>
            <hr>

            <span class=""></span>
            <button type="submit" class="btn__primary ms-3 col-lg-2 col-10">Actualizar</button>
        </form>
    </div>

@endsection