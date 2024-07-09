@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/show-data.css')}}">
@endsection

@section('content')
    
    <div class="p-lg-4">
        <h2>Nuevo producto</h2>
        <form 
            action="{{route('productos.store')}}"
            method="POST" 
            enctype="multipart/form-data" class="row"
        >
            @csrf

            <div class="row row-cols-lg-4 row-cols-md-2  row-cols-1">

                <div class="form-group mb-4 mb-lg-0">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4 mb-lg-0">
                    <label for="precio">Precio:</label>
                    <input type="number" class="form-control @error('precio') is-invalid @enderror" id="precio" name="precio" value="{{ old('precio') }}" required>
                    @error('precio')
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

                @include('productos.partials.categorias')

            </div>

            <span class="mt-lg-4"></span>

            <button type="submit" class="btn__primary ms-3 col-lg-2 col-10">Registrar</button>
        </form>
    </div>

@endsection