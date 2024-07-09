@extends('layout')

@section('content')
    
    <div class="p-lg-4">
        <h2>Editar funcionalidad</h2>
        <form 
            action="{{route('funcionalidades.update', $funcionalidad)}}"
            method="POST" 
            class="row"
        >
            @csrf
            @method("PUT")

            <div class="row row-cols-lg-3 row-cols-md-3 row-cols-1">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input
                        type="text"
                        class="form-control"
                        id="nombre"
                        name="nombre" value="{{ $funcionalidad->nombre }}"
                        required
                    >
                </div>

                <div class="form-group mt-lg-0 mt-md-0 mt-4">
                    <label for="descripcion">Descripción:</label>
                    <textarea 
                        class="form-control" 
                        id="descripcion" 
                        name="descripcion">
                        {{ $funcionalidad->descripcion }}
                    </textarea>
                </div>

                <div class="form-group mt-lg-0 mt-md-0 mt-4">
                    <label for="estado">Estado Activo:</label>
                    <select class="form-control" id="estado" name="estado" required>
                        <option
                            value="1"
                            {{ $funcionalidad->estado == 1 ? 'selected' : '' }}>
                            Activo
                        </option>
                        <option
                            value="0"
                            {{ $funcionalidad->estado == 0 ? 'selected' : '' }}>
                            Inactivo
                        </option>
                    </select>
                </div>

            </div>

            <span class="mt-4"></span>
            <hr>

            <span class=""></span>
            <button type="submit" class="btn__secondary ms-3 col-lg-2 col-10">Actualizar</button>
        </form>
    </div>

@endsection

@section('js')
    <script>
        var textarea = document.getElementById('descripcion');
        textarea.textContent = textarea.textContent.trim();
    </script>
@endsection