@extends('layout')

@section('content')
    <div class="p-lg-4">
        <h2>{{ $producto->nombre }}</h2>
        <form 
            action="{{route('productos.update', $producto)}}" 
            method="POST"
            class="row"
        >
            
            @csrf
            @method("PUT")

            <div class="row row-cols-lg-4 row-cols-md-2  row-cols-1">

                <div class="form-group mb-4 mb-lg-0">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ $producto->nombre }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4 mb-lg-0">
                    <label for="precio">Precio:</label>
                    <input type="number" class="form-control @error('precio') is-invalid @enderror" id="precio" name="precio" value="{{ $producto->precio }}" required>
                    @error('precio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mb-4 mb-lg-0">
                    <label for="estado">Estado Activo:</label>
                    <select class="form-control @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                        <option value="1" {{ $producto->estado == 1 ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ $producto->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="precio" class="fw-bold">Categoría:</label>
                    <select class="form-select" name="id_categoria" id="categoriaSelect">
                        @foreach ($categorias as $categoria)
                            <option
                                class="fs-5"
                                value="{{ $categoria->id }}"
                                {{ 
                                    $producto->categoria->id == $categoria->id
                                    ? 'selected' : ''
                                }}
                            > 
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <span class="mt-lg-4"></span>

            <button type="submit" class="btn__primary ms-3 col-lg-2 col-10">Actualizar</button>
        </form>
    </div>

@endsection

@section('js')
    <script>
        var textarea = document.getElementById('descripcion');
        textarea.addEventListener("click", () => {
            textarea.setSelectionRange(0, 0);
        });
    </script>
@endsection