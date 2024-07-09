@extends('layout')

@section('content')
    
    <div class="p-lg-4">
        <h2>Nuevo cliente</h2>
        <form 
            action="{{route('clientes.store')}}"
            method="POST" 
            enctype="multipart/form-data" class="row"
        >
            @csrf

            <div class="row row-cols-lg-4 row-cols-md-2  row-cols-1">

                <div class="form-group mb-4 mb-lg-0">
                    <label for="nombre">Nombres:</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4 mb-lg-0">
                    <label for="apellido">Apellidos:</label>
                    <input type="text" class="form-control @error('apellido') is-invalid @enderror" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                    @error('apellido')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4 mb-lg-0">
                    <label for="genero">Genero:</label>
                    <select class="form-control @error('genero') is-invalid @enderror" id="genero" name="genero" required>
                        <option value="M" {{ old('genero') === 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('genero') === 'F' ? 'selected' : '' }}>Femenino</option>
                    </select>
                    @error('genero')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4 mb-lg-0">
                    <label for="estado">Estado Activo:</label>
                    <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                        <option value="1" {{ old('estado') == 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ old('estado') == 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <span class="mt-4"></span>
            <hr>

            <button type="submit" class="btn__primary ms-3 col-lg-2 col-10">Registrar</button>
        </form>
    </div>

@endsection