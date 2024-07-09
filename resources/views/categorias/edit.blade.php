@extends('layout')

@section('content')
    <div class="p-lg-4">
        <h2>{{ $categoria->nombre }}</h2>
        <form 
            action="{{route('categorias.update', $categoria)}}" 
            method="POST"
            class="row"
        >
            
            @csrf
            @method("PUT")

            <div class="row row-cols-lg-4 row-cols-md-2  row-cols-1">

                <div class="form-group mb-4 mb-lg-0">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ $categoria->nombre }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4 mb-lg-0">
                    <label for="estado">Estado Activo:</label>
                    <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                        <option value="1" {{ $categoria->estado == 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ $categoria->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <span class="mt-4"></span>
            <hr>

            <button type="submit" class="btn__primary ms-3 col-lg-2 col-10">Actualizar</button>
        </form>
    </div>

@endsection