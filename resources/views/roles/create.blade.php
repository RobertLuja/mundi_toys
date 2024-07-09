@extends('layout')

@section('content')
    
    <div class="p-lg-4">
        <h2>Nuevo Rol</h2>
        <form 
            action="{{route('roles.store')}}"
            method="POST" 
            class="row"
        >
            @csrf

            <div class="row row-cols-1">
                <div class="form-group">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <span class="mt-4"></span>

                <div class="form-group">
                    <label for="descripcion">Descripción:</label>
                    <textarea
                        class="form-control 
                        @error('descripcion') is-invalid 
                        @enderror" 
                        id="descripcion"
                        name="descripcion"
                    >{{ old('descripcion') }}
                    </textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <span class="mt-4"></span>
            <hr>

            <span class=""></span>
            <button type="submit" class="btn__primary ms-3 col-lg-2 col-10">Registrar</button>
        </form>
    </div>

@endsection

@section('js')
    <script>
        var textarea = document.getElementById('descripcion');
        textarea.addEventListener("click", () => {
            textarea.setSelectionRange(0, 0);
        })
    </script>
@endsection