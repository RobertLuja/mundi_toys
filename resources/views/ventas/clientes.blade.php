@extends('layout')

@section('content')
    <div class="">
        <form action="{{ route('ventas.createCarrito') }}" method="post">
            @csrf
            <div>
                <label for="search" class="fs-5">Cliente</label>
                <input 
                    class="form-control @error('ci') is-invalid 
                    @enderror" 
                    type="number"
                    id="searchCliente"
                    name="ci"
                    placeholder="Buscar ci"
                >
                @error('ci')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <label for="" id="csrf" hidden="true">{{ csrf_token() }}</label>
            </div>
            <div class="mt-2" id="displayEmpleado"></div>
    
            <button type="submit" class="btn__primary">Continuar</button>
        </form>
    </div>
    @if (session("info"))
        <x-alert2
            icon="bi bi-exclamation-circle"
            color="crimson"
            title="Cliente alert"
            description="{{session('info')}}"
        />
    @endif
@endsection

@section('js')
    <script>
        var searchCliente = document.getElementById('searchCliente');

        searchCliente.addEventListener('keyup', function() {
            if (searchCliente.value) {
                searchProveedorM();
            };
        });

        function searchProveedorM() {
            var query = searchCliente.value;
            if (query.length >= 2) { // Realizar la búsqueda solo si se han ingresado al menos 2 caracteres

                sendData(
                    "../users/clientes",
                    {
                    "query": query
                    }
                )
                .then(res => res.json())
                .then(data => {           
                    displayResultsProveedor(data);
                })
                .catch(error => console.error('Error al realizar la búsqueda:', error));
            }
        }

        function displayResultsProveedor(usuarios) {
            displayEmpleado.innerHTML = ''; // Limpiar los resultados anteriores

            usuarios.forEach(usuario => {
                var usuarioUl = document.createElement('ul');
                var pNombre = document.createElement('p');
                var liNombre = document.createElement('li');

                pNombre.innerHTML = `Nombre: ${usuario.nombre} ${usuario.apellido} | CI: ${usuario.ci}`;
                
                liNombre.appendChild(pNombre);

                usuarioUl.appendChild(liNombre);
                
                displayEmpleado.appendChild(usuarioUl);
            });
        }
    </script>
@endsection