@extends('layout')

@section('css')
    <link rel="stylesheet" href="{{asset('css/show-data.css')}}">
@endsection

@section('content')
    
    <div class="p-lg-4">
        <h2>Nuevo almacen</h2>
        <form 
            action="{{route('almacenes.store')}}"
            method="POST" 
            enctype="multipart/form-data" class="row"
        >
            @csrf

            <div class="row row-cols-lg-3 row-cols-md-2  row-cols-1">

                <div class="form-group mb-4 mb-lg-0">
                    <label for="nombre">Nombre:</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
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

            <span class="mt-lg-4"></span>
            
            <div class="row row-cols-lg-3 row-cols-md-2  row-cols-1">
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

            <div class="row row-cols-lg-3 row-cols-md-2  row-cols-1">
                @include('almacenes.partials.sucursals')
            </div>

            <span class="mt-4"></span>
            <hr>

            <button type="submit" class="btn__primary ms-3 col-lg-2 col-10">Registrar</button>
        </form>
    </div>

@endsection

@section('js')
    <script>
        var textarea = document.getElementById('descripcion');
        textarea.addEventListener("click", () => {
            textarea.setSelectionRange(0, 0);
        });

        const sucursalSelect = document.getElementById('sucursalSelect');

        sucursalSelect.addEventListener('change', function() {

            var sucursalId = sucursalSelect.value;
            sendData(
                "../sucursals/buscarById",
                {
                "query": sucursalId
                }
            )
            .then(res => res.json())
            .then(data => {
                    const sucursal = data;
                    console.log(sucursal);
                    document.getElementById("infoSucursal").style.display = "block";

                    document.getElementById("nombreSucursal").textContent = sucursal.nombre;
                    document.getElementById("direccionSucursal").textContent = sucursal.direccion;
            })
            .catch(error => console.error('Error al realizar la búsqueda:', error));
        });
    </script>
@endsection